document.addEventListener("DOMContentLoaded", () => {

    const buttons = document.querySelectorAll(".add-to-cart");

    buttons.forEach(button => {

        button.addEventListener("click", () => {

            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = button.dataset.price;

            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            const existing = cart.find(item => item.id === id);

            if(existing){
                existing.quantity += 1;
            } else {

                cart.push({
                    id,
                    name,
                    price,
                    quantity: 1
                });

            }

            localStorage.setItem("cart", JSON.stringify(cart));

            alert("Dodano do koszyka!");

        });

    });

});