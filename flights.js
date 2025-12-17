let currentDepartDate = new Date('2024-12-20');
let currentReturnDate = new Date('2025-01-28');
let adults = 1;
let children = 0;
let fromCity = 'Pristina';
let fromCode = 'PRN';
let toCity = 'London';
let toCode = 'LHR';

function formatDate(date) {
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]}`;
}

function updateDates() {
    document.getElementById('depart-date').textContent = formatDate(currentDepartDate);
    document.getElementById('return-date').textContent = formatDate(currentReturnDate);
}

function changeDate(days, type) {
    if (type === 'depart') {
        currentDepartDate.setDate(currentDepartDate.getDate() + days);
    } else {
        currentReturnDate.setDate(currentReturnDate.getDate() + days);
    }
    updateDates();
}

function editRoute() {
    const newFrom = prompt('Enter departure city (e.g., Pristina):', fromCity);
    const newFromCode = prompt('Enter departure airport code (e.g., PRN):', fromCode);
    const newTo = prompt('Enter destination city (e.g., London):', toCity);
    const newToCode = prompt('Enter destination airport code (e.g., LHR):', toCode);
    const newAdults = prompt('Number of adults:', adults);
    const newChildren = prompt('Number of children:', children);
    
    if (newFrom && newFromCode) {
        fromCity = newFrom;
        fromCode = newFromCode;
    }
    
    if (newTo && newToCode) {
        toCity = newTo;
        toCode = newToCode;
    }
    
    document.getElementById('route-text').textContent = 
        `${fromCity} (${fromCode}) – ${toCity} (${toCode})`;
    
    if (newAdults !== null) {
        adults = parseInt(newAdults) || 1;
        children = parseInt(newChildren) || 0;
        
        let passengerText = `${adults} adult${adults !== 1 ? 's' : ''}`;
        if (children > 0) {
            passengerText += `, ${children} child${children !== 1 ? 'ren' : ''}`;
        } else {
            passengerText += `, 0 children`;
        }
        document.getElementById('passenger-text').textContent = passengerText;
    }
}

document.querySelector('.summary-search').addEventListener('click', editRoute);

updateDates();

document.addEventListener('DOMContentLoaded', function() {

    const selectAllBtn = document.querySelector('.select-all');
    const baggageCheckboxes = document.querySelectorAll('.baggage-option input[type="checkbox"]');
    
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', function() {
            const allChecked = Array.from(baggageCheckboxes).every(cb => cb.checked);
            baggageCheckboxes.forEach(cb => cb.checked = !allChecked);
            selectAllBtn.textContent = allChecked ? 'Select all' : 'Deselect all';
        });
    }
    
    const durationSlider = document.querySelector('.duration-range input[type="range"]');
    const durationValue = document.querySelector('.duration-value');
    
    if (durationSlider && durationValue) {
        durationSlider.addEventListener('input', function() {
            durationValue.textContent = `${this.value} hours`;
        });
    }
    
    const timeSliders = document.querySelectorAll('.time-range input[type="range"]');
    timeSliders.forEach(slider => {
        const timeSpan = slider.parentElement.querySelector('span');
        slider.addEventListener('input', function() {
            const hour = parseInt(this.value);
            const nextHour = hour + 1;
            timeSpan.textContent = `${hour.toString().padStart(2, '0')}:00 - ${nextHour.toString().padStart(2, '0')}:00`;
        });
    });
});