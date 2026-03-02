// console.log("Hello World");

// function timesTwo(inputNumber) {
//     return inputNumber * 2;
// }

// const timesTwo = inputNumber => inputNumber * 2;

// console.log(timesTwo(1) + 5);

// console.log(myName);

// let myName = "Salvo";

let user = {
    firstName: "Salvo",
    lastName: "Donatella",
    age: 19, 
    hobbies: ['drive my truck', 'drink my beer', 'catch my fish'],
    friends: [
        {
            firstName: "Sean",
            lastName: "Burger",
            age: 3
            },
        {
            firstName: "Sean",
            lastName: "Mustard",
            age: 67
            },
    ],
};

console.log(user.friends[0].lastName);

let donuts = ["Chocolate", "Jam", "Custard"]

donuts.forEach((donut, i) => {
    // console.log((   i + 1) + " " + donut);
    console.log(`Option ${i+1}: ${donut}`)
});