let fuelRequested = document.querySelector("#gallonsRequested");
fuelRequested.addEventListener("keydown", preventSpace);
fuelRequested.addEventListener("input", calPrice);

function preventSpace(event){
    if (event.key === " "){
        event.preventDefault();
    }
}

function calPrice(){
    let fuel = this.value;
    document.querySelector("#totalAmountDue").value = (fuel * pricePerGallon).toFixed(2);
}