// Product data
const products = [
    {
        id: 1,
        name: "Chicken Momo",
        description: "Juicy chicken wrapped in soft dough with authentic spices",
        price: 250,
        image: "https://images.unsplash.com/photo-1496412705862-e0088f16f791?w=400&h=300&fit=crop",
        category: "non-veg"
    },
    {
        id: 2,
        name: "Veg Momo",
        description: "Fresh vegetables and herbs in traditional steamed dumplings",
        price: 200,
        image: "https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop",
        category: "veg"
    },
    {
        id: 3,
        name: "Paneer Momo",
        description: "Cottage cheese with aromatic spices in delicate wrappers",
        price: 280,
        image: "https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&h=300&fit=crop",
        category: "veg"
    },
    {
        id: 4,
        name: "Buff Momo",
        description: "Traditional buffalo meat momos with authentic Nepali taste",
        price: 300,
        image: "https://images.unsplash.com/photo-1563379091755-de3815efea9b?w=400&h=300&fit=crop",
        category: "non-veg"
    },
    {
        id: 5,
        name: "Chicken Chilli Momo",
        description: "Spicy chicken momos with chilli and garlic flavoring",
        price: 320,
        image: "https://images.unsplash.com/photo-1606491956689-2ea866880c84?w=400&h=300&fit=crop",
        category: "non-veg"
    },
    {
        id: 6,
        name: "Mixed Veg Momo",
        description: "Assorted vegetables with mushrooms and tofu blend",
        price: 230,
        image: "https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop",
        category: "veg"
    }
];

// Cart
let cart = JSON.parse(localStorage.getItem('frozenMomoCart')) || [];

// Load products into the grid
function loadProducts() {
    const productsGrid = $('#productsGrid');
    if (productsGrid.length === 0) return; // only run on products page

    productsGrid.empty();

    products.forEach(product => {
        const productCard = `
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="product-card zoom-in">
                    <div class="product-image" style="background-image: url('${product.image}')"></div>
                    <div class="product-info">
                        <h4 class="product-title">${product.name}</h4>
                        <p class="product-description">${product.description}</p>
                        <div class="product-price">Rs. ${product.price}</div>
                        <button class="btn btn-custom w-100" onclick="addToCart(${product.id})">
                            <i class="fas fa-cart-plus me-2"></i>Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `;
        productsGrid.append(productCard);
    });
}

// Add to cart
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }

    updateCartBadge();
    saveCart();

    // Animate badge
    gsap.to('.cart-badge', { scale: 1.5, duration: 0.3, yoyo: true, repeat: 1 });

    showToast(`${product.name} added to cart!`, 'success');
}

// Remove from cart
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartBadge();
    saveCart();
    loadCart();
}

// Update item quantity
function updateQuantity(productId, change) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            updateCartBadge();
            saveCart();
            loadCart();
        }
    }
}

// Update cart badge
function updateCartBadge() {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    $('#cartBadge').text(totalItems);
}

// Save cart
function saveCart() {
    localStorage.setItem('frozenMomoCart', JSON.stringify(cart));
}

// Toggle cart modal
function toggleCart() {
    loadCart();
    const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
    cartModal.show();
}

// Load cart content
function loadCart() {
    const cartItems = $('#cartItems');
    const cartTotal = $('#cartTotal');

    if (cart.length === 0) {
        cartItems.html(`
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5>Your cart is empty</h5>
                <p class="text-muted">Add some delicious momos to get started!</p>
            </div>
        `);
        cartTotal.text('0');
        return;
    }

    let itemsHtml = '';
    let total = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        itemsHtml += `
            <div class="cart-item d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <img src="${item.image}" alt="${item.name}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                    <div>
                        <h6 class="mb-1">${item.name}</h6>
                        <small class="text-muted">Rs. ${item.price} each</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <button class="quantity-btn me-2" onclick="updateQuantity(${item.id}, -1)"><i class="fas fa-minus"></i></button>
                    <span>${item.quantity}</span>
                    <button class="quantity-btn ms-2" onclick="updateQuantity(${item.id}, 1)"><i class="fas fa-plus"></i></button>
                    <div class="ms-3 fw-bold">Rs. ${itemTotal}</div>
                    <button class="btn btn-sm btn-outline-danger ms-3" onclick="removeFromCart(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });

    cartItems.html(itemsHtml);
    cartTotal.text(total);
}

// Checkout
function checkout() {
    if (cart.length === 0) {
        showToast('Your cart is empty!', 'warning');
        return;
    }

    loadOrderSummary();

    const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    orderModal.show();
}

// Order summary
function loadOrderSummary() {
    const orderSummary = $('#orderSummary');
    const orderTotal = $('#orderTotal');

    let summaryHtml = '';
    let total = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        summaryHtml += `
            <div class="d-flex justify-content-between mb-2">
                <span>${item.name} x ${item.quantity}</span>
                <span>Rs. ${itemTotal}</span>
            </div>
        `;
    });

    orderSummary.html(summaryHtml);
    orderTotal.text(total);
}

// Place order
function placeOrder() {
    if (cart.length === 0) return;

    const orderNumber = 'FMO' + Date.now().toString().slice(-6);

    showOrderSuccess(orderNumber);

    cart = [];
    updateCartBadge();
    saveCart();
}

// Success modal
function showOrderSuccess(orderNumber) {
    const successHtml = `
        <div class="modal fade" id="successModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body text-center py-5">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h3>Order Placed Successfully!</h3>
                        <p>Your order number is: <strong>#${orderNumber}</strong></p>
                        <button type="button" class="btn btn-custom" data-bs-dismiss="modal">Continue Shopping</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    $('#successModal').remove();
    $('body').append(successHtml);

    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}

// Toast
function showToast(message, type = 'info') {
    const toastHtml = `
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show text-white bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    `;
    $('body').append(toastHtml);
    setTimeout(() => $('.toast-container').fadeOut(() => $('.toast-container').remove()), 3000);
}

// Animations
function initAnimations() {
    gsap.set('.slide-in-left', { opacity: 0, x: -100 });
    gsap.set('.slide-in-right', { opacity: 0, x: 100 });
    gsap.set('.zoom-in', { opacity: 0, scale: 0.8 });

    // Fade-in
    gsap.set('.fade-in', { opacity: 0 });
    gsap.to('.fade-in', { opacity: 1, duration: 0.8, ease: "power2.out" });

    // Fade-out (if you want to trigger fade-out, add .fade-out to the element and call this as needed)
    // gsap.to('.fade-out', { opacity: 0, duration: 0.8, ease: "power2.in" });

    gsap.to('.slide-in-left', { opacity: 1, x: 0, duration: 0.8, ease: "power3.out" });
    gsap.to('.slide-in-right', { opacity: 1, x: 0, duration: 0.8, delay: 0.2, ease: "power3.out" });
    gsap.utils.toArray('.product-card').forEach((card, i) => {
        gsap.to(card, { opacity: 1, scale: 1, duration: 0.6, delay: i * 0.1, ease: "back.out(1.7)" });
    });
}

// Init
$(document).ready(function () {
    updateCartBadge();
    loadProducts();   // auto-load if productsGrid exists
    initAnimations();
});
