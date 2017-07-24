import pangu from "pangu/dist/browser/pangu";

export default converter => [{
    type: "output",
    filter: text => {
        let doc = document.implementation.createHTMLDocument();
        doc.body.innerHTML = text;

        // Task lists
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

        // Responsive tables
        doc.body.querySelectorAll("table").forEach(table => {
            let container = doc.createElement("div");
            container.className = "table-container";

            table.after(container);
            container.appendChild(table);
        });

        pangu.spacingNode(doc.body);

        return doc.body.innerHTML;
    }
}];
