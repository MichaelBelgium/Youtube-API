document.addEventListener('DOMContentLoaded', () => {
    const frmConvert = document.getElementById('frm-convert');
    const removeButton = document.getElementById('remove');
    const frmSearch = document.getElementById('frm-search');

    frmConvert.addEventListener('submit', (e) => {
        e.preventDefault();
        const submitButton = frmConvert.querySelector("button[type=submit]");
        const link = document.getElementById('link').value;
        const format = document.getElementById('format').value;

        submitButton.classList.add("disabled");
        submitButton.innerHTML = "<i class=\"fas fa-spin fa-sync-alt\"></i> Converting...";

        const endpoint = `${frmConvert.getAttribute("action")}?youtubelink=${link}&format=${format}`;

        fetch(endpoint)
            .then(response => response.json())
            .then(data => handleConvertResponse(data, submitButton));
    });

    removeButton.addEventListener('click', () => {
        const id = removeButton.getAttribute('data-id');
        fetch(`convert.php?delete=${id}`)
            .then(response => response.json())
            .then(data => alert(data.message));
    });

    frmSearch.addEventListener('submit', (e) => {
        e.preventDefault();

        const submitButton = frmSearch.querySelector("button[type=submit]");
        const query = document.getElementById('q').value;
        const maxResults = document.getElementById('max_results').value;

        submitButton.classList.add("disabled");
        submitButton.innerHTML = "<i class=\"fas fa-spin fa-sync-alt\"></i> Searching...";

        fetch(`${frmSearch.getAttribute('action')}?q=${query}&max_results=${maxResults}`)
            .then(response => response.json())
            .then(data => handleSearchResponse(data, submitButton));
    });
});

function handleConvertResponse(data, submitButton) {
    document.getElementById("convert-response").querySelector('pre').innerText = JSON.stringify(data, null, 4);
    submitButton.innerHTML = "<i class=\"fa fa-sync-alt\"></i> Convert";
    submitButton.classList.remove("disabled");

    const tableCells = document.querySelectorAll("#convert-response table tr td:last-child");
    const downloadButton = document.getElementById('download');
    const removeButton = document.getElementById('remove');

    if(data.error) {
        tableCells[0].innerHTML = "<i class=\"fa fa-check\"></i>";
        tableCells[1].innerText = data.message;
        tableCells[2].innerText = "-";
        tableCells[3].innerText = "0";
        tableCells[4].innerText = "-";
        tableCells[5].innerText = "-";

        downloadButton.setAttribute("href", "#");
        downloadButton.classList.add("disabled");
    } else {
        tableCells[0].innerHTML = "<i class=\"fa fa-times\"></i>";
        tableCells[1].innerText = "-";
        tableCells[2].innerText = `${data.title} (${data.alt_title})`;
        tableCells[3].innerText = data.duration;
        tableCells[4].innerText = data.youtube_id;
        tableCells[5].innerText = new Date(data.uploaded_at.date).toLocaleString();

        downloadButton.setAttribute("href", data.file);
        downloadButton.classList.remove("disabled");

        removeButton.setAttribute('data-id', data.youtube_id);
        removeButton.classList.remove('disabled');
    }
}

function handleSearchResponse(data, submitButton) {
    submitButton.innerHTML = "<i class=\"fa fa-search\"></i> Search";
    submitButton.classList.remove("disabled");

    const preElement = document.getElementById("search-response").querySelector('pre');
    preElement.innerText = JSON.stringify(data, null, 4);

    const tableCells = document.querySelectorAll("#search-response table tr td:last-child");
    const ulElement = document.querySelector("#search-response table tr:nth-child(3) td:last-child ul");
    ulElement.innerHTML = '';

    if(data.error) {
        tableCells[0].innerHTML = "<i class=\"fa fa-check\"></i>";
        tableCells[1].innerText = data.message;
    } else {
        tableCells[0].innerHTML = "<i class=\"fa fa-times\"></i>";
        tableCells[1].innerText = "-";

        data.results.forEach(el => {
            const btn = document.createElement('button');
            btn.className = 'ms-3 btn btn-sm btn-outline-secondary';
            btn.innerText = 'Convert';
            btn.onclick = () => {
                document.getElementById('link').value = el.full_link;
                document.getElementById('link').scrollIntoView({behavior: "smooth"});
                return false;
            };

            const a = document.createElement('a');
            a.href = el.full_link;
            a.innerText = el.title;

            const item = document.createElement('li');
            item.appendChild(a);
            item.appendChild(btn);

            ulElement.appendChild(item);
        });
    }
}