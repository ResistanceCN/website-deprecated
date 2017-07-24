import Home from "../pages/Home.vue";
import Login from "../pages/Login.vue"
import Register from "../pages/Register.vue";
import Article from "../pages/Article.vue";
import Form from "../pages/Form.vue";

const routes = [
    { path: "/", component: Home, name: "home" },
    { path: "/login", component: Login, name: "login" },
    { path: "/register", component: Register, name: "register" },
    { path: "/article/:id(\\d+)", component: Article, name: "article" },
    { path: "/form/:name(\\w+)", component: Form, name: "form" }
];

export default routes;
