document.addEventListener('DOMContentLoaded', function () {
    const URLROOT = 'https://192.168.0.125/evCalendar';

    const searchBtn = document.getElementById("searchBtn");
    const searchInput = document.getElementById("autocomplete-input");
    const searchInputNav = document.getElementById("autocomplete-input-nav");
    const searchBtnNav = document.getElementById("searchBtnNav");

    function getKeywordAndSend(searchInput) {
        window.location = `${URLROOT}/events/searchEvent?keyword=${searchInput}&page=1`;
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', function (event) {
            const searchInput = document.getElementById('autocomplete-input').value;
            if (!searchInput || searchInput === "" || searchInput === null || searchInput === " " || searchInput.length < 3) {
                alert('Invalid keyword or too short.');
                return false;
            }
            getKeywordAndSend(searchInput);
        });
    }

    if (searchInput) {
        searchInput.addEventListener('change', function (event) {
            const searchInput = event.target.value;
            if (!searchInput || searchInput === "" || searchInput === null || searchInput === " " || searchInput.length < 3) {
                alert('Invalid keyword or too short.');
                return false;
            }
            getKeywordAndSend(searchInput);
        });

    }

    if (searchBtnNav) {
        searchBtnNav.addEventListener('click', function (event) {
            const searchInput = document.getElementById("autocomplete-input-nav").value;
            if (!searchInput || searchInput === "" || searchInput === null || searchInput === " " || searchInput.length < 3) {
                alert('Invalid keyword or too short.');
                return false;
            }
            getKeywordAndSend(searchInput);
        });
    }

    if (searchInputNav) {
        searchInputNav.addEventListener('change', function (event) {
            const searchInput = event.target.value;
            if (!searchInput || searchInput === "" || searchInput === null || searchInput === " " || searchInput.length < 3) {
                alert('Invalid keyword or too short.');
                return false;
            }
            getKeywordAndSend(searchInput);
        });
    }
})