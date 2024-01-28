function calculateValues() {
  // Get values from input fields
  var freshLatexWeight =
    parseFloat(document.getElementById("freshLatexWeight").value) || 0;
  var percentageObtained =
    parseFloat(document.getElementById("percentageObtained").value) || 0;
  var pricePerKilogram =
    parseFloat(document.getElementById("pricePerKilogram").value) || 0;

  // Check if required fields are filled
  var isFieldsValid =
    freshLatexWeight > 0 && percentageObtained > 0 && pricePerKilogram > 0;

  // Calculate dry rubber and total price if all required fields are filled
  if (isFieldsValid) {
    var dryRubber = (freshLatexWeight * percentageObtained) / 100;
    var totalPrice = dryRubber * pricePerKilogram;

    // Display calculated values
    document.getElementById("dryRubber").value = dryRubber.toFixed(2);
    document.getElementById("totalPrice").value = totalPrice.toFixed(2);
  } else {
    // error
    alert("กรอก น้ำหนัก และ เปอร์เซ็นต์ ให้ครบทุกช่อง.");
  }
}

function saveData() {
  var calculateButton = document.getElementById("calculateButton");

  // Check if the Calculate button is disabled
  //   if (calculateButton.disabled) {
  //     alert("Please fill in all required fields and calculate before saving.");
  //     return;
  //   }

  // Get values of dryRubber and totalPrice
  var dryRubberValue =
    parseFloat(document.getElementById("dryRubber").value) || 0;
  var totalPriceValue =
    parseFloat(document.getElementById("totalPrice").value) || 0;

  // Check if values are greater than 0
  if (dryRubberValue <= 0 || totalPriceValue <= 0) {
    alert("Please enter values greater than 0 for dryRubber and totalPrice.");
    return;
  }
}
