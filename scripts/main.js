document.addEventListener('click', function(e) {
    const { target } = e;
    if(!target.matches("nav a")) return;
    e.preventDefault();
    urlRoute();
});

const urlRoutes = {
    404: {
        template: "/templates/404.html",
        title : "Page Not Found",
        description : ""
    },

    "/": {
        template: "../templates/home.html",
        title : "Home",
        description : ""
    },

    "/login": {
        template: "../templates/login.html",
        title : "Login",
        description : ""
    },

    "/register": {
        template: "../templates/register.html",
        title : "Register",
        description : ""
    },
}

const urlRoute = (event) => {
    event = event || window.event;
    event.preventDefault();
    window.history.pushState({}, '', event.target.href);
    urlLocationHandler();
}

const urlLocationHandler = async () => {
    const location = window.location.pathname;
    if (location.length == 0){
        console.log("Redirecting to /");
        location = '/';
    }

    console.log(location);

    const route = urlRoutes[location] || urlRoutes[404];
    const html = await fetch(route.template).then((response) => response.text());
    document.getElementById("content").innerHTML = html;
    document.title = route.title + " | Bizou";

}

window.onpopstate = urlLocationHandler;
window.route = urlRoute;
console.log("URL Router Loaded");
urlLocationHandler();