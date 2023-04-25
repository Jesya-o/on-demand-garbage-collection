// Add and remove lines of bulk waste
// Get the form container
const formContainer = document.querySelector('.form-container');

// Get the add button
const addButton = document.querySelector('.add-btn');

// Add a click event listener to the add button
addButton.addEventListener('click', () => {
  // Create a new form line
  const newFormLine = document.createElement('div');
  newFormLine.classList.add('form-line');

  // Determine the number of existing form lines
  const numFormLines = formContainer.querySelectorAll('.form-line').length;

  if (numFormLines >= 10) {
    addButton.style.display = 'none';
    return;
  }

  // Add the HTML for the new form line
  newFormLine.innerHTML = `
    <label for="selector${numFormLines + 1}" class="item">Item ${numFormLines + 1}</label>
    <select name="selector[]" id="selector${numFormLines + 1}">
      <option value="option1">1 - 20 kg</option>
      <option value="option2">21 - 50 kg</option>
      <option value="option3">51 - 100 kg</option>
      <option value="option4">101 - 200 kg</option>
      <option value="option5">201 - 500 kg</option>
    </select>
    <button class="remove-btn">&minus;</button>
  `;

  // Add a click event listener to the remove button
  const removeButton = newFormLine.querySelector('.remove-btn');
  removeButton.addEventListener('click', () => {
    newFormLine.remove();
    addButton.style.display = 'inline-block';
    updateFormLineLabels();
  });

  // Add the new form line to the form container
  formContainer.insertBefore(newFormLine, addButton.parentElement);

  // Update the labels for all form lines
  updateFormLineLabels();
});

// Update the labels for all form lines
function updateFormLineLabels() {
  const formLines = formContainer.querySelectorAll('.form-line');
  formLines.forEach((formLine, index) => {
    const label = formLine.querySelector('label');
    if (label) {
      label.textContent = `Item ${index + 1}`;
      const select = formLine.querySelector('select');
      select.id = `selector${index + 1}`;
      label.setAttribute('for', `selector${index + 1}`);
    }
  });
}

// Restore form lines based on stored session values
document.addEventListener('DOMContentLoaded', () => {
  const selectedItems = '<?= $selectedItems ?>'.split('|');
  const formContainer = document.querySelector('.form-container');
  const addButton = document.querySelector('.add-btn');

  selectedItems.forEach((item, index) => {
    if (index > 0) {
      addButton.click();
    }
    const formLine = formContainer.querySelector(`.form-line:nth-child(${index + 1})`);
    const selectElement = formLine.querySelector('select');
    selectElement.value = item;
  });
});
