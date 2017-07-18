import xss from "xss";
import { whiteList } from "xss/lib/default"

let options = {
    whiteList: {
        ...whiteList,
        input: ["type", "disabled", "checked"],
        li: ["class"],
        td: ["width", "rowspan", "colspan", "align", "valign", "style"],
        i: ["class"]
    }
};

export default converter => [{
    type: "output",
    filter: text => xss(text, options)
}];
