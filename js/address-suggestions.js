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

    // Initialize Autocomplete for the house input field
    autocompleteHouse = new google.maps.places.Autocomplete(document.getElementById('house'), {
      types: ['address'],
      componentRestrictions: { country: 'ee' },
    });

    // Add event listener to the house input field
    autocompleteHouse.addListener('place_changed', onHouseChanged);
  }

  // Handle the place_changed event for the street input field
  function onStreetChanged() {
    const place = autocompleteStreet.getPlace();

    if (!place.address_components) {
      alert('No details available for the selected address');
      return;
    }

    // Filter results by Tallinn
    const cityComponent = place.address_components.find((component) => component.types.includes('locality'));
    if (cityComponent && cityComponent.long_name !== 'Tallinn') {
      alert('Please select a street within Tallinn');
      document.getElementById('street').value = '';
      return;
    }

    // Extract street name
    const streetComponent = place.address_components.find((component) => component.types.includes('route'));
    if (streetComponent) {
      selectedStreetName = streetComponent.long_name;
      document.getElementById('street').value = selectedStreetName;
    }
  }

  // Handle the place_changed event for the house input field
  function onHouseChanged() {
    const place = autocompleteHouse.getPlace();

    if (!place.address_components) {
      alert('No details available for the selected address');
      return;
    }

    // Extract address components
    let streetName = '';
    let houseNumber = '';
    let postalCode = '';

    for (const component of place.address_components) {
      const componentType = component.types[0];

      switch (componentType) {
        case 'route':
          streetName = component.long_name;
          break;
        case 'street_number':
          houseNumber = component.long_name;
          break;
        case 'postal_code':
          postalCode = component.long_name;
          break;
      }
    }

    // Check if the selected street name matches the previously selected street name
    if (streetName !== selectedStreetName) {
      alert('Please select a house number on the selected street');
      document.getElementById('house').value = '';
      return;
    }

    // Update input fields with the extracted values
    document.getElementById('house').value = houseNumber;
    document.getElementById('index').value = postalCode;
  }

  // Run the initAutocomplete function when the DOM is fully loaded
  google.maps.event.addDomListener(window, 'load', initAutocomplete);

  function fetchPostalCode(street, houseNumber) {
    const geocoder = new google.maps.Geocoder();
    const address = `${street} ${houseNumber}, Tallinn, Estonia`;
  
    geocoder.geocode({ address: address }, (results, status) => {
      if (status === 'OK') {
        const postalCodeComponent = results[0].address_components.find((component) =>
          component.types.includes('postal_code')
        );
  
        if (postalCodeComponent) {
          document.getElementById('index').value = postalCodeComponent.long_name;
        } else {
          alert('Postal code not found');
        }
      } else {
        alert(`Geocoder failed due to: ${status}`);
      }
    });
  }
  document.getElementById('house').addEventListener('blur', () => {
    const streetValue = document.getElementById('street').value;
    const houseValue = document.getElementById('house').value;
  
    if (streetValue && houseValue) {
      fetchPostalCode(streetValue, houseValue);
    }
  });
  function fixDropdownPosition(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
      input.addEventListener('focus', () => {
        const observer = new MutationObserver((mutations) => {
          mutations.forEach((mutation) => {
            if (mutation.target.style.top !== '') {
              updateDropdownPosition(input, mutation.target);
            }
          });
        });
        const pacContainer = document.querySelector('.pac-container');
        if (pacContainer) {
          observer.observe(pacContainer, { attributes: true, attributeFilter: ['style'] });
        }
      });
  
      input.addEventListener('blur', () => {
        const pacContainer = document.querySelector('.pac-container');
        if (pacContainer) {
          pacContainer.style.top = '';
          pacContainer.style.left = '';
        }
      });
    }
  }
  
  function updateDropdownPosition(input, container) {
    const rect = input.getBoundingClientRect();
    container.style.top = `${rect.bottom + window.scrollY}px`;
    container.style.left = `${rect.left + window.scrollX}px`;
  }
  
  fixDropdownPosition('street');
  
  function disablePageScroll(inputId) {
    const input = document.getElementById(inputId);
    if (input) {
      input.addEventListener('focus', () => {
        document.body.style.overflowY = 'hidden';
      });
  
      input.addEventListener('blur', () => {
        document.body.style.overflowY = 'auto';
      });
    }
  }
  
  disablePageScroll('street');
    