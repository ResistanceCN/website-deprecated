export default converter => [{
    type: "output",
    filter: text => {
        let doc = document.implementation.createHTMLDocument();
        doc.body.innerHTML = text;

        doc.body.querySelectorAll("li.task-list-item").forEach(li => {
            let checkbox = li.querySelector("input[type='checkbox']");

            let icon = doc.createElement("i");
            icon.className = "material-icons";

            if (checkbox.checked) {
                icon.innerText = "check_box"
            } else {
                icon.innerText = "check_box_outline_blank"
            }

            checkbox.remove();
            li.prepend(icon)
        });

        return doc.body.innerHTML;
    }
}];
