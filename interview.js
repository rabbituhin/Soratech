let currentDate = new Date();
let selectedDate = null;
let selectedTime = null;
const bookedSlots = {};
const bookings = [];

// This will allow us to show "January 2025" instead of "1 2025"
const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];

const timeSlots = [
    "09:00 AM", "10:00 AM", "11:00 AM", "12:00 PM",
    "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM"
];

// This displays the calendar
function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    // This updates the header section of the calendar to be the current date & month
    
    document.getElementById('monthYear').textContent = `${monthNames[month]} ${year}`;
    
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    const calendarDays = document.getElementById('calendarDays');
    calendarDays.innerHTML = '';
    
    // Get today's date and set time to midnight to avoid comparison issues
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    // This fills out the last days of the last month
    // For example, Let's say November 2025 starts on Saturday (firstDay = 6)
    // Those 6 boxes should show: Oct 26, Oct 27, Oct 28, Oct 29, Oct 30, Oct 31
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = document.createElement('div');
        day.className = 'day other-month';
        day.textContent = daysInPrevMonth - i;
        calendarDays.appendChild(day);
    }
    
    // This loop creates boxes for days of the current month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayEl = document.createElement('div');
        dayEl.className = 'day';
        dayEl.textContent = day;
        
        const dayDate = new Date(year, month, day);
        dayDate.setHours(0, 0, 0, 0);
        
        // This disables(greys out) the previous days, current day and weekends or booked days
        if (dayDate <= today) {
            dayEl.classList.add('disabled');
        } else {
            if (dayDate.getDay() === 0 || dayDate.getDay() === 6) {
                dayEl.classList.add('disabled');
            } else {
                // check if the future day has any bookings
                const dateKey = `${year}-${month}-${day}`;
                if (bookedSlots[dateKey]) {
                    dayEl.classList.add('has-booking');
                }
                
                dayEl.addEventListener('click', () => selectDate(day));
            }
        }
        // This highlights today in the calendar
        if (dayDate.getTime() === today.getTime()) {
            dayEl.classList.add('today');
        }
        // This makes sure a day is selected and matches
        if (selectedDate && selectedDate.getDate() === day && 
            selectedDate.getMonth() === month && selectedDate.getFullYear() === year) {
            dayEl.classList.add('selected');
        }
        
        calendarDays.appendChild(dayEl);
    }
    
    // This calculates the remain cells and fill the next month days
    const totalCells = calendarDays.children.length;
    const remainingCells = 42 - totalCells;
    for (let i = 1; i <= remainingCells; i++) {
        const day = document.createElement('div');
        day.className = 'day other-month';
        day.textContent = i;
        calendarDays.appendChild(day);
    }
}

// Makes prev and next month arrow display the right dates
document.getElementById('prevMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

function selectDate(day) {
    selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
    renderCalendar();
    renderTimeSlots();
    checkFormValid();
}

// This clears out the timeslots and tells the user to pick a date first
function renderTimeSlots() {
    const timeSlotsEl = document.getElementById('timeSlots');
    timeSlotsEl.innerHTML = '';
    
    if (!selectedDate) {
        timeSlotsEl.innerHTML = '<p style="color: #999;">Please select a date first</p>';
        return;
    }
    // Checks if there are booked time for the selected day or empty
    const dateKey = `${selectedDate.getFullYear()}-${selectedDate.getMonth()}-${selectedDate.getDate()}`;
    const bookedTimes = bookedSlots[dateKey] || [];
    
    timeSlots.forEach(time => {
        const slot = document.createElement('div');
        slot.className = 'time-slot';
        slot.textContent = time;
        
        if (bookedTimes.includes(time)) {
            slot.classList.add('booked');
        } else {
            if (selectedTime === time) {
                slot.classList.add('selected');
            }
            slot.addEventListener('click', () => selectTime(time));
        }
        
        timeSlotsEl.appendChild(slot);
    });
}

function selectTime(time) {
    selectedTime = time;
    renderTimeSlots();
    checkFormValid();
}

// This checks if the form is valid and disables the book button if not
function checkFormValid() {
    const name = document.getElementById('candidateName').value;
    const email = document.getElementById('email').value;
    const position = document.getElementById('position').value;
    const bookBtn = document.getElementById('bookBtn');
    
    if (selectedDate && selectedTime && name && email && position) {
        bookBtn.disabled = false;
    } else {
        bookBtn.disabled = true;
    }
}

function getSelectedReminders() {
    const reminders = [];
    if (document.getElementById('reminder24').checked) reminders.push('24 hours before');
    if (document.getElementById('reminder1').checked) reminders.push('1 hour before');
    if (document.getElementById('reminder15').checked) reminders.push('15 minutes before');
    return reminders;
}

// This displays the confirmation pop-up details
function showConfirmModal() {
    const position = document.getElementById('position').value;
    const reminders = getSelectedReminders();
    
    document.getElementById('confirmDate').textContent = selectedDate.toLocaleDateString('en-UK', { 
        day: 'numeric', weekday: 'long', month: 'long', year: 'numeric'
    });
    document.getElementById('confirmTime').textContent = selectedTime;
    document.getElementById('confirmPosition').textContent = position;
    document.getElementById('confirmReminders').textContent = reminders.length > 0 ? reminders.join(', ') : 'None';
    
    document.getElementById('confirmModal').classList.add('active');
}

// This runs after the user confirms the booking
function confirmBooking() {
    const dateKey = `${selectedDate.getFullYear()}-${selectedDate.getMonth()}-${selectedDate.getDate()}`;
    if (!bookedSlots[dateKey]) {
        bookedSlots[dateKey] = [];
    }
    // Adds it to the booked slot section
    bookedSlots[dateKey].push(selectedTime);
    
    const booking = {
        name: document.getElementById('candidateName').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        position: document.getElementById('position').value,
        date: selectedDate,
        time: selectedTime,
        notes: document.getElementById('notes').value,
        reminders: getSelectedReminders()
    };
    bookings.push(booking);
    
    document.getElementById('confirmModal').classList.remove('active');
    // Shows the success pop-up with thier email
    document.getElementById('successEmail').textContent = booking.email;
    document.getElementById('successModal').classList.add('active');

    // This clears up all the fields
    selectedTime = null;
    renderCalendar();
    renderTimeSlots();
    renderBookings();
    document.getElementById('candidateName').value = '';
    document.getElementById('email').value = '';
    document.getElementById('phone').value = '';
    document.getElementById('position').value = '';
    document.getElementById('notes').value = '';
    checkFormValid();
}

// This diplays confirmed booking 
function renderBookings() {
    const bookingsList = document.getElementById('bookingsList');
    if (bookings.length === 0) {
        bookingsList.innerHTML = '';
        return;
    }
    
    bookingsList.innerHTML = '<div class="section-title" style="margin-top: 20px;">Your Bookings</div>';
    bookings.forEach(booking => {
        const item = document.createElement('div');
        item.className = 'booking-item';
        item.innerHTML = `
            <h4>Position: ${booking.position}</h4>
            <p>Booking date and time: ${booking.date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} at ${booking.time}</p>
            <p>Name ${booking.name}</p>
        `;
        bookingsList.appendChild(item);
    });
}
// These are event listerners for booking buttons to show or hide pop ups
document.getElementById('bookBtn').addEventListener('click', showConfirmModal);

document.getElementById('cancelConfirm').addEventListener('click', () => {
    document.getElementById('confirmModal').classList.remove('active');
});

document.getElementById('confirmBook').addEventListener('click', confirmBooking);
document.getElementById('closeSuccess').addEventListener('click', () => {
    document.getElementById('successModal').classList.remove('active');
});

// Whenever user types in name, email, or position fields, it checks the form
['candidateName', 'email', 'position'].forEach(id => {
    document.getElementById(id).addEventListener('input', checkFormValid);
});

renderCalendar();
renderTimeSlots();