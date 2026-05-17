function showToast(message){

    document.getElementById("toast-message")
        .innerText = message;

    const toast = new bootstrap.Toast(
        document.getElementById('liveToast')
    );

    toast.show();
}

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
            
            updateCartCount();
            showToast("Dodano produkt do koszyka!");

        });

    });

});

function updateCartCount(){

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let total = 0;

    cart.forEach(item => {
        total += item.quantity;
    });

    const counter = document.getElementById("cart-count");

    if(counter){
        counter.innerText = `(${total})`;
    }
}

updateCartCount();