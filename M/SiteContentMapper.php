<?php
require_once __DIR__ . '/../Database.php';

class SiteContentMapper extends Database {

    public function get($page, $key, $default = '') {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT content_value FROM site_content WHERE page = ? AND content_key = ?");
            $stmt->execute([$page, $key]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['content_value'] : $default;
        } catch (PDOException $e) {
            return $default;
        }
    }

    public function set($page, $key, $value) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("INSERT INTO site_content (page, content_key, content_value) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE content_value = VALUES(content_value)");
            return $stmt->execute([$page, $key, $value]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllByPage($page) {
        try {
            $conn = $this->getConnection();
            $stmt = $conn->prepare("SELECT content_key, content_value FROM site_content WHERE page = ?");
            $stmt->execute([$page]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            foreach ($rows as $r) {
                $result[$r['content_key']] = $r['content_value'];
            }
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function saveBatch($page, $data) {
        foreach ($data as $key => $value) {
            $this->set($page, $key, $value);
        }
        return true;
    }
}
