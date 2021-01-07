let table, tbody, pagination;
let page = 1;
let domain = null;
let domains = [];
let items = [];
let paginationData = [];

function init() {
    table = document.getElementById("subscription-table");
    tbody = table.getElementsByTagName("tbody")[0];
    pagination = document.getElementById("pagination");

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
                populateTable(page, b);
                populateDomains();
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
        for(var i = 0; i < items.length; i++) {
            let row = tbody.insertRow(i);
            row.id = 'row-' + i;
            let email = row.insertCell(0);
            email.innerHTML = items[i].email;
            let date = row.insertCell(1);
            date.innerHTML = timeConverter(items[i].created_at);
            let actionsColumn = row.insertCell(2);
            let actionsButtons = createActions(i);
            actionsButtons.forEach(b => actionsColumn.appendChild(b));
        }

        console.log(response);
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
    console.log(del);
    return [del];
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
            console.log(response);
        });
    }

    populateTable(page, domain);
    populateDomains();
}

function updatePagination(currentPage, nextPage, previousPage, maxPages) {
    console.log({currentPage, nextPage, previousPage, maxPages});
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