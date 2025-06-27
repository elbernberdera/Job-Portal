/**
 * Address Dropdowns Component
 * Handles dynamic loading of regions, provinces, cities, and barangays
 * using the official PSGC API
 */
class AddressDropdowns {
    constructor(options = {}) {
        this.options = {
            regionSelect: '#region',
            provinceSelect: '#province',
            citySelect: '#city',
            barangaySelect: '#barangay',
            loadingText: 'Loading...',
            placeholderText: 'Select...',
            ...options
        };

        this.elements = {
            region: document.querySelector(this.options.regionSelect),
            province: document.querySelector(this.options.provinceSelect),
            city: document.querySelector(this.options.citySelect),
            barangay: document.querySelector(this.options.barangaySelect)
        };

        this.init();
    }

    init() {
        this.loadRegions();
        this.bindEvents();
    }

    bindEvents() {
        if (this.elements.region) {
            this.elements.region.addEventListener('change', () => {
                this.onRegionChange();
            });
        }

        if (this.elements.province) {
            this.elements.province.addEventListener('change', () => {
                this.onProvinceChange();
            });
        }

        if (this.elements.city) {
            this.elements.city.addEventListener('change', () => {
                this.onCityChange();
            });
        }
    }

    async loadRegions() {
        try {
            this.setLoading(this.elements.region, true);
            const response = await fetch('/api/regions');
            const data = await response.json();

            if (data.success && data.regions) {
                this.populateSelect(this.elements.region, data.regions, 'name', 'code');
            } else {
                console.error('Failed to load regions:', data.message);
            }
        } catch (error) {
            console.error('Error loading regions:', error);
        } finally {
            this.setLoading(this.elements.region, false);
        }
    }

    async onRegionChange() {
        const regionCode = this.elements.region.value;
        if (!regionCode) {
            this.clearSelect(this.elements.province);
            this.clearSelect(this.elements.city);
            this.clearSelect(this.elements.barangay);
            return;
        }

        try {
            this.setLoading(this.elements.province, true);
            const response = await fetch(`/api/provinces?region_code=${regionCode}`);
            const data = await response.json();

            if (data.success && data.provinces) {
                this.populateSelect(this.elements.province, data.provinces, 'name', 'code');
                this.clearSelect(this.elements.city);
                this.clearSelect(this.elements.barangay);
            } else {
                console.error('Failed to load provinces:', data.message);
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
        } finally {
            this.setLoading(this.elements.province, false);
        }
    }

    async onProvinceChange() {
        const provinceCode = this.elements.province.value;
        if (!provinceCode) {
            this.clearSelect(this.elements.city);
            this.clearSelect(this.elements.barangay);
            return;
        }

        try {
            this.setLoading(this.elements.city, true);
            const response = await fetch(`/api/cities?province_code=${provinceCode}`);
            const data = await response.json();

            if (data.success && data.cities) {
                this.populateSelect(this.elements.city, data.cities, 'name', 'code');
                this.clearSelect(this.elements.barangay);
            } else {
                console.error('Failed to load cities:', data.message);
            }
        } catch (error) {
            console.error('Error loading cities:', error);
        } finally {
            this.setLoading(this.elements.city, false);
        }
    }

    async onCityChange() {
        const cityCode = this.elements.city.value;
        if (!cityCode) {
            this.clearSelect(this.elements.barangay);
            return;
        }

        try {
            this.setLoading(this.elements.barangay, true);
            const response = await fetch(`/api/barangays?city_code=${cityCode}`);
            const data = await response.json();

            if (data.success && data.barangays) {
                this.populateSelect(this.elements.barangay, data.barangays, 'name', 'code');
            } else {
                console.error('Failed to load barangays:', data.message);
            }
        } catch (error) {
            console.error('Error loading barangays:', error);
        } finally {
            this.setLoading(this.elements.barangay, false);
        }
    }

    populateSelect(selectElement, data, labelKey, valueKey) {
        if (!selectElement) return;

        // Clear existing options
        selectElement.innerHTML = '';

        // Add placeholder
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = this.options.placeholderText;
        selectElement.appendChild(placeholder);

        // Add data options
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item[valueKey];
            option.textContent = item[labelKey];
            selectElement.appendChild(option);
        });
    }

    clearSelect(selectElement) {
        if (!selectElement) return;
        selectElement.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = this.options.placeholderText;
        selectElement.appendChild(placeholder);
    }

    setLoading(selectElement, isLoading) {
        if (!selectElement) return;

        if (isLoading) {
            selectElement.disabled = true;
            const currentValue = selectElement.value;
            selectElement.innerHTML = '';
            const loadingOption = document.createElement('option');
            loadingOption.value = '';
            loadingOption.textContent = this.options.loadingText;
            selectElement.appendChild(loadingOption);
            selectElement.value = currentValue;
        } else {
            selectElement.disabled = false;
        }
    }

    // Public methods for external use
    getSelectedValues() {
        return {
            region: this.elements.region?.value || '',
            province: this.elements.province?.value || '',
            city: this.elements.city?.value || '',
            barangay: this.elements.barangay?.value || ''
        };
    }

    getSelectedTexts() {
        return {
            region: this.elements.region?.options[this.elements.region?.selectedIndex]?.text || '',
            province: this.elements.province?.options[this.elements.province?.selectedIndex]?.text || '',
            city: this.elements.city?.options[this.elements.city?.selectedIndex]?.text || '',
            barangay: this.elements.barangay?.options[this.elements.barangay?.selectedIndex]?.text || ''
        };
    }

    // Method to pre-select values (useful for editing forms)
    setValues(regionCode = '', provinceCode = '', cityCode = '', barangayCode = '') {
        if (regionCode && this.elements.region) {
            this.elements.region.value = regionCode;
            this.onRegionChange().then(() => {
                if (provinceCode && this.elements.province) {
                    this.elements.province.value = provinceCode;
                    this.onProvinceChange().then(() => {
                        if (cityCode && this.elements.city) {
                            this.elements.city.value = cityCode;
                            this.onCityChange().then(() => {
                                if (barangayCode && this.elements.barangay) {
                                    this.elements.barangay.value = barangayCode;
                                }
                            });
                        }
                    });
                }
            });
        }
    }
}

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AddressDropdowns;
} else {
    window.AddressDropdowns = AddressDropdowns;
} 