import Home from "./pages/Home.vue";
import Login from "./pages/Login.vue"
import Register from "./pages/Register.vue";
import Article from "./pages/Article.vue";

const routes = [
    { path: "/", component: Home, name: "home" },
    { path: "/login", component: Login, name: "login" },
    { path: "/register", component: Register, name: "register" },
    { path: "/article/:id(\\d+)", component: Article, name: "article" }
];

export default routes
