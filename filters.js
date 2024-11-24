const models = {
    toyota: ['Camry', 'Corolla'],
    nissan: ['Altima', 'Sentra'],
    dodge: ['Charger', 'Challenger'],
    honda: ['Accord', 'Civic']
};

const years = {
        Camry: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Corolla: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Altima: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Sentra: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Charger: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Challenger: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Accord: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        Civic: ['2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
    };

function updateModels() {
    const brandSelect = document.getElementById('brand');
    const modelSelect = document.getElementById('model');
    const yearSelect = document.getElementById('year');

    const selectedBrand = brandSelect.value;

    modelSelect.innerHTML = '<option value="">Select Model</option>';
    yearSelect.innerHTML = '<option value="">Select Year</option>';
    yearSelect.disabled = true;

    if (selectedBrand) {
        const availableModels = models[selectedBrand];
        availableModels.forEach(model => {
            const option = document.createElement('option');
            option.value = model;
            option.textContent = model;
            modelSelect.appendChild(option);
        });
        modelSelect.disabled = false; 
    }
    toggleButton();
}

function updateYears() {
    const modelSelect = document.getElementById('model');
    const yearSelect = document.getElementById('year');

    const selectedModel = modelSelect.value;

    yearSelect.innerHTML = '<option value="">Select Year</option>';

    if (selectedModel) {
        const availableYears = years[selectedModel];
        availableYears.forEach(year => {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        });
        yearSelect.disabled = false; 
    }
}


function toggleButton(){
    const brandSelect = document.getElementById('brand');
    const goButton = document.getElementById('gobutton');

    if(brandSelect.value){
        goButton.disabled = false;
    }
    else{
        goButton.disabled = true;
    }

}



function applyFilters() {
    const brand = document.getElementById('brand').value;
    const model = document.getElementById('model').value;
    const year = document.getElementById('year').value;

    const queryString = `brand=${encodeURIComponent(brand)}&model=${encodeURIComponent(model)}&year=${encodeURIComponent(year)}`;
    window.location.href = `results.html?${queryString}`;
}






document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const search = document.getElementById('searchInput').value.trim();
    const queryString = `search=${encodeURIComponent(search)}`;
    window.location.href = `results.html?${queryString}`;
});


function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    document.getElementById('cartcount').textContent = cart.length;
}
