// Declare global variables
let autocompleteStreet, autocompleteHouse;
let selectedStreetName = '';

// Initialize Autocomplete for the street input field
function initAutocomplete() {
  autocompleteStreet = new google.maps.places.Autocomplete(document.getElementById('street'), {
    types: ['address'],
    componentRestrictions: { country: 'ee' },
  });

  // Add event listener to the street input field
  autocompleteStreet.addListener('place_changed', onStreetChanged);
}

// Handle the place_changed event for the street input field
function onStreetChanged() {
  const place = autocompleteStreet.getPlace();

  if (!place.address_components) {
    showMessage('No details available for the selected address');
    return;
  }

  const cityComponent = place.address_components.find((component) => component.types.includes('locality'));
  if (cityComponent && cityComponent.long_name !== 'Tallinn') {
    showMessage('Please select a street within Tallinn');
    document.getElementById('street').value = '';
    return;
  }

  const streetComponent = place.address_components.find((component) => component.types.includes('route'));
  if (streetComponent) {
    selectedStreetName = streetComponent.long_name;
    document.getElementById('street').value = selectedStreetName;

    // Check if house number is entered, and regenerate postal code if required
    const houseValue = document.getElementById('house').value;
    if (houseValue) {
      fetchPostalCode(selectedStreetName, houseValue);
    } else {
      fetchPostalCode(selectedStreetName, 1);
    }
  }
}


// When the DOM is fully loaded, run the initAutocomplete function
google.maps.event.addDomListener(window, 'load', initAutocomplete);

// Define a function fetchPostalCode that takes a street name and house number as input
function fetchPostalCode(street, houseNumber) {
  // Create a new instance of the Geocoder class
  const geocoder = new google.maps.Geocoder();
  // Construct a string representing the address using the street name, house number, and city name
  const address = `${street} ${houseNumber}, Tallinn, Estonia`;

  // Call the geocode method on the Geocoder instance to retrieve location information for the address
  geocoder.geocode({ address: address }, (results, status) => {
    // Check if the geocoding request was successful
    if (status === 'OK') {
      // Find the postal code component in the address components returned by the geocoder
      const postalCodeComponent = results[0].address_components.find((component) =>
        component.types.includes('postal_code')
      );
      // If a postal code component was found, set the value of the 'index' input field to the postal code
      if (postalCodeComponent) {
        document.getElementById('index').value = postalCodeComponent.long_name;
      } else {
        // If no postal code component was found, display an error message to the user
        showMessage('Postal code not found');
      }
    } else {
      // If the geocoding request failed, display an error message to the user with the reason for the failure
      showMessage(`Geocoder failed due to: ${status}`);
    }
  });
}

// Attach a blur event listener to the 'house' input element.
document.getElementById('house').addEventListener('blur', () => {
  // Retrieve the values of the 'street' and 'house' input elements.
  const streetValue = document.getElementById('street').value;
  const houseValue = document.getElementById('house').value;

  // Check if both 'street' and 'house' input elements have a value.
  if (streetValue && houseValue) {
    // Call the 'fetchPostalCode()' function with the 'street' and 'house' values.
    fetchPostalCode(streetValue, houseValue);
  }
});

// Define a function to fix the position of a dropdown menu based on the input element's position.
function fixDropdownPosition(inputId) {
  // Retrieve the input element with the provided ID.
  const input = document.getElementById(inputId);

  // If the input element exists, attach event listeners to its focus and blur events.
  if (input) {
    // Attach a focus event listener to the input element.
    input.addEventListener('focus', () => {
      // Create a MutationObserver to watch for changes in the dropdown menu's position.
      const observer = new MutationObserver((mutations) => {
        // For each mutation, check if the 'top' style attribute has changed.
        mutations.forEach((mutation) => {
          if (mutation.target.style.top !== '') {
            // If the 'top' attribute has changed, update the dropdown menu's position.
            updateDropdownPosition(input, mutation.target);
          }
        });
      });

      // Retrieve the dropdown menu container.
      const pacContainer = document.querySelector('.pac-container');

      // If the dropdown menu container exists, start observing its style attribute.
      if (pacContainer) {
        observer.observe(pacContainer, { attributes: true, attributeFilter: ['style'] });
      }
    });

    // Attach a blur event listener to the input element.
    input.addEventListener('blur', () => {
      // Retrieve the dropdown menu container.
      const pacContainer = document.querySelector('.pac-container');

      // If the dropdown menu container exists, reset its position.
      if (pacContainer) {
        pacContainer.style.top = '';
        pacContainer.style.left = '';
      }
    });
  }
}

// This function updates the position of a dropdown container relative to the position of an input field
function updateDropdownPosition(input, container) {
  // Get the bounding rectangle of the input field
  const rect = input.getBoundingClientRect();
  // Set the position of the container to be just below the input field
  container.style.top = `${rect.bottom + window.scrollY}px`;
  container.style.left = `${rect.left + window.scrollX}px`;
}

// Call the updateDropdownPosition function with the 'street' input and its corresponding container
updateDropdownPosition('streetInput', 'streetDropdown');

// This function disables scrolling on the page when a specified input field is in focus
function disablePageScroll(inputId) {
  // Get the input field by ID
  const input = document.getElementById(inputId);
  if (input) {
    // Add an event listener to disable scrolling when the input field is in focus
    input.addEventListener('focus', () => {
      document.body.style.overflowY = 'hidden';
    });
    // Add an event listener to re-enable scrolling when the input field loses focus
    input.addEventListener('blur', () => {
      document.body.style.overflowY = 'auto';
    });
  }
}

// Call the disablePageScroll function with the 'street' input ID
disablePageScroll('streetInput');

// This function displays a message to the user on the web page
function showMessage(message) {
  // Get the message container element by ID
  const messageContainer = document.getElementById("messageContainer");
  // Set the inner HTML of the message container to display the message
  messageContainer.innerHTML = message + '<br><br>Click on me to hide the message now';
  // Set the message container to be visible
  messageContainer.style.display = "block";
  // Add an event listener to hide the message container when it is clicked
  messageContainer.addEventListener("click", function () {
    messageContainer.style.display = "none";
  });

  // Set a timeout to hide the message container after 3 seconds
  setTimeout(() => {
    messageContainer.style.display = "none";
  }, 3000);
}
