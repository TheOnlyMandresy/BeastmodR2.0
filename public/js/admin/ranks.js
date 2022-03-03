function checkAll(section, bool) {
    let id = 'rights-' + section;
    let box = document.getElementById(id);
    let button = box.getElementsByClassName('selectAll')[0];
    let inputs = box.querySelectorAll('input[name="idRights[]"]');

    if (bool) {
        for (var i=0; i<inputs.length; i++) {
            inputs[i].checked = bool;
        }
        button.setAttribute('onclick',"checkAll('" +section+ "', false)");
    } else {
        for (var i=0; i<inputs.length; i++) {
            inputs[i].checked = bool;
        }
        button.setAttribute('onclick',"checkAll('" +section+ "', true)");
    }
}