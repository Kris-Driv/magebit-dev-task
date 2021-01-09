let table, tbody, pagination;
let page = 1;
let domain = null;
let domains = [];
let items = [];
let paginationData = [];
let selected = [];
let selectedData = null;
let download = null;

function init() {
    table = document.getElementById("subscription-table");
    tbody = table.getElementsByTagName("tbody")[0];
    pagination = document.getElementById("pagination");
    download = document.getElementById("download");
    selectedData = new Map();

    download.addEventListener("click", () => downloadCSV(selectedData));

    populateTable(page, null);
    populateDomains();
}

function populateDomains() {
    $.ajax({
        url: '/get-all-domains'
    }).then(response => {
        domains = response.domains;
        console.log(domains);

        let list = document.getElementById("domains");
        list.innerHTML = "";
        domains.forEach(b => {
            let li = document.createElement("li");
            let btn = document.createElement("button");
            btn.classList.add("btn");
            if(domain === b) btn.classList.add("btn-primary");
            else btn.classList.add("btn-dark");
            btn.innerHTML = b;
            btn.addEventListener("click", () => {
                // Reset the domain filter
                if(domain === b) {
                    btn.classList.remove("btn-primary");
                    btn.classList.add("btn-dark");
                    populateTable(page);
                } else {
                    populateTable(page, b);
                    populateDomains();
                }
            });
            li.appendChild(btn)
            list.appendChild(li);
        });

    }, err => {
        console.log(err);
    });
}

function populateTable(_page, _domain = null) {
    page = _page;
    domain = _domain;

    $.ajax({
        url: '/get-all',
        data: {
            page: page || 1,
            domain
        }
    }).then(response => {
        // Clean placeholder row
        tbody.innerHTML = "";

        items = response.items;
        sorted = [];
        for(var i = 0; i < items.length; i++) {
            let row = tbody.insertRow(i);
            let id = items[i].id || i;
            sorted[id] = items[i];
            row.id = 'row-' + id;
            row.dataset.id = id;
            let email = row.insertCell(0);
            email.innerHTML = items[i].email;
            let date = row.insertCell(1);
            date.innerHTML = timeConverter(items[i].created_at);
            let actionsColumn = row.insertCell(2);
            actionsColumn.style = "position: relative;";
            let actionsButtons = createActions(id);
            actionsButtons.forEach(b => actionsColumn.appendChild(b));
        }
        items = sorted;

        updatePagination(response.page, response.next, response.previous, response['total-pages']);
    }, err => {
        console.error(err);
    });
}

function createActions(id) {
    let del = document.createElement("button");
    del.innerHTML = "Delete";
    del.classList.add("btn");
    del.classList.add("btn-danger");
    del.addEventListener('click', () => {
        deleteSubscription(id);
    });

    let checkbox = document.createElement('input');
    checkbox.type = "checkbox";
    checkbox.name = "download";
    checkbox.value = false;
    checkbox.id = "checkbox-" + id;
    checkbox.style = "position: absolute; right: 5px; width: 20px; height: 20px; top: 16px";
    checkbox.checked = selected.indexOf(id) >= 0;
    checkbox.addEventListener("click", () => {
        //console.log({id, indexOf: selected.indexOf(id)});
        if(selected.indexOf(id) >= 0) {
            selected.splice(selected.indexOf(id), 1);
            selectedData.delete(id);
        } else {
            selectedData.set(id, items[id]);
            selected.push(id);
            // console.log(items);
        }
        console.log(selectedData);
        updateDownload();
    });

    return [del, checkbox];
}

function updateDownload() {
    download.disabled = selected.length <= 0;
    download.innerHTML = ("Download" + (download.disabled ? "" : ` (${selected.length})`));
}

function deleteSubscription(id) {
    let row = document.getElementById('row-' + id);
    if(row) {
        let email = row.children[0].innerHTML;
        
        $.ajax({
            url: '/delete',
            data: {
                email,
            }
        }).then(response => {
            // deleted
        });
    }

    populateTable(page, domain);
    updateDownload();
    populateDomains();
}

function updatePagination(currentPage, nextPage, previousPage, maxPages) {
    pagination.innerHTML = "";

    let li;
    // Previous button
    li = document.createElement("li");
    pb = document.createElement("a");
    pb.href = "#";
    pb.innerHTML = "Previous";
    pb.addEventListener('click', () => {
        populateTable(previousPage);
    });
    li.classList.add('page-item');
    pb.classList.add('page-link');
    if(previousPage === null) li.classList.add('disabled');
    li.appendChild(pb);
    pagination.appendChild(li);

    // Current
    li = document.createElement("li");
    cb = document.createElement("a");
    cb.href = "#";
    cb.innerHTML = currentPage;
    li.classList.add('page-item');
    li.classList.add('active');
    cb.classList.add('page-link');
    li.appendChild(cb);
    pagination.appendChild(li);

    // Next button
    li = document.createElement("li");
    nb = document.createElement("a");
    nb.href = "#";
    nb.innerHTML = "Next";
    nb.addEventListener('click', () => {
        populateTable(nextPage);
    });
    li.classList.add('page-item');
    nb.classList.add('page-link')
    if(nextPage === null) li.classList.add('disabled');
    li.appendChild(nb);
    pagination.appendChild(li);
}

function downloadCSV(list, keys) {
    let csv = "";
    keys = keys || ["id", "email", "created_at"];

    const headers = keys.map(key => `"${key}"`).join(',');

    list.forEach(entry => {
        console.log(entry);
        keys.forEach(key => csv += entry[key] + ",");
        csv = csv.trimEnd(",") + "\n";
    });
    csv = headers + "\n" + csv.replace(/,\s*$/, "");

    const blob = new Blob(["\ufeff", csv], {type: 'text/csv'});
    var url = URL.createObjectURL(blob);
    var downloadLink = document.createElement("a");
    downloadLink.href = url;
    downloadLink.download = "emails.csv";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.appendChild(downloadLink);
    URL.revokeObjectURL(url);

    console.log(blob);
}

function timeConverter(time){
    var a = new Date(time * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
    return time;
  }