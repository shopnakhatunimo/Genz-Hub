// Search functionality
const Search = {
    debounceTimer: null,
    
    init() {
        const searchInput = document.querySelector('[data-search-input]');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.handleSearch(e.target.value);
            });
        }
    },
    
    handleSearch(query) {
        clearTimeout(this.debounceTimer);
        
        if (query.length < 2) {
            this.hideResults();
            return;
        }
        
        this.debounceTimer = setTimeout(() => {
            this.fetchResults(query);
        }, 300);
    },
    
    async fetchResults(query) {
        try {
            const response = await fetch(`/search?q=${encodeURIComponent(query)}`);
            const html = await response.text();
            this.showResults(html);
        } catch (error) {
            console.error('Search error:', error);
        }
    },
    
    showResults(html) {
        let resultsContainer = document.querySelector('[data-search-results]');
        
        if (!resultsContainer) {
            resultsContainer = document.createElement('div');
            resultsContainer.setAttribute('data-search-results', '');
            resultsContainer.className = 'absolute top-full left-0 right-0 bg-white shadow-lg rounded-lg mt-2 max-h-96 overflow-y-auto z-50';
            document.querySelector('[data-search-wrapper]').appendChild(resultsContainer);
        }
        
        resultsContainer.innerHTML = html;
        resultsContainer.classList.remove('hidden');
    },
    
    hideResults() {
        const resultsContainer = document.querySelector('[data-search-results]');
        if (resultsContainer) {
            resultsContainer.classList.add('hidden');
        }
    }
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    Search.init();
});

// Make available globally
window.Search = Search;
