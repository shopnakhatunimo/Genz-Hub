// Wishlist functionality
const Wishlist = {
    async add(productId) {
        try {
            const response = await fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ product_id: productId }),
            });
            const data = await response.json();
            
            showToast(data.message, data.success ? 'success' : 'error');
            return data.success;
        } catch (error) {
            showToast('সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'error');
            return false;
        }
    },
    
    async remove(productId) {
        try {
            const response = await fetch('/wishlist/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ product_id: productId }),
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
    
    toggle(productId) {
        const button = event.target.closest('button');
        const isAdded = button.classList.contains('added');
        
        if (isAdded) {
            this.remove(productId);
            button.classList.remove('added');
        } else {
            this.add(productId).then(success => {
                if (success) {
                    button.classList.add('added');
                }
            });
        }
    }
};

// Make available globally
window.Wishlist = Wishlist;
