let textBox = document.getElementById("cover");
let counter = document.getElementById("count");
let form = document.getElementById("applyForm");
let note = document.getElementById("note");

textBox.oninput = function(){
    counter.innerText = textBox.value.length + " / 500";
};

form.onsubmit = function(ev){
    ev.preventDefault();
    note.style.color = "green";
    note.innerText = "Application sent successfully.";
};