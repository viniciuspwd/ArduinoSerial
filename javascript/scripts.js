function updateStatus ()
{
    if (status) {
        let newStatus = (status == 'on') ? 'off' : 'on';
    
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', 'index.php?status=' + newStatus + '&no-render', true);
        xhttp.onreadystatechange = function (response) {
            let res = response.currentTarget.responseText;

            if (res != '') {
                console.log(res)
            }
        };
        xhttp.send();
    }
}
