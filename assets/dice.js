// Roll the dice button
var button = document.querySelector(".startRoll");
button.addEventListener("click", start);

function start() {

  button.disabled = true;


  var randomNumber1 = 6;
  var randomNumber2 = 6;

  axios
  .post(
<<<<<<< HEAD
    "http://3.139.87.137/xchange/xChange/dice_result.php"
=======
    "/dice_result.php"
>>>>>>> 47fafafb7fa545cc9171d1bcc4914e70045e410a
  )
  .then(function(response) {
    if (response.data.status == "success") { 
      // First Dice
      randomNumber1 = response.data.number1; //(Math.floor(Math.random() * 6) + 1); // 1-6
      document.querySelector(".img1").setAttribute("src", "images/dice/dice" + randomNumber1 + ".png"); // dice1.png - dice6.png

      // Second Dice
      randomNumber2 = response.data.number2; //(Math.floor(Math.random() * 6) + 1); // 1-6
      document.querySelector(".img2").setAttribute("src", "images/dice/dice" + randomNumber2 + ".png");
    }
    else {
      console.log(response.data);
    }
  })
  .catch(function(error) {
    alert("Server is not working, try it later!");
    console.error(error);
  })
  .finally(function() {
    button.disabled = false;
    // Results
    // player 1 wins
    if (randomNumber1 > randomNumber2) {
      document.querySelector("h1").innerHTML = "&#128522; You Won!";
    }
    // player 2 wins
    else if (randomNumber1 < randomNumber2) {
      document.querySelector("h1").innerHTML = "You lost! &#128529;";
    }
    // draw 
    else {
      document.querySelector("h1").innerHTML = "Draw!";
    }
  });

}