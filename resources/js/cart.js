// Cart functionality
const Cart = {
    async add(productId, quantity = 1) {
        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                }),
            });
            const data = await response.json();
            
            if (data.success) {
                showToast(data.message, 'success');
                this.updateCartCount(data.cart_count);
                return true;
            } else {
                showToast(data.message, 'error');
                return false;
            }
        } catch (error) {
            showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
            return false;
        }
    },
    
    async update(itemId, quantity) {
        if (quantity < 1) return;
        
        try {
            const response = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: quantity,
                }),
            });
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            }
        } catch (error) {
            showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
        }
    },
    
    async remove(itemId) {
        if (!confirm('আপনি কি এই পণ্যটি সরাতে চান?')) return;
        
        try {
            const response = await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ item_id: itemId }),
            });
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            }
        } catch (error) {
            showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
        }
    },
    
    async applyCoupon(code) {
        try {
            const response = await fetch('/cart/coupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ coupon_code: code }),
            });
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            } else {
                showToast(data.message, 'error');
            }
        } catch (error) {
            showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
        }
    },
    
    updateCartCount(count) {
        document.querySelectorAll('[data-cart-count]').forEach(el => {
            el.textContent = count;
        });
    }
};

// Make available globally
window.Cart = Cart;
