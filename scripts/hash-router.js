const routes = {
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

    login: {
        template: "../templates/login.html",
        title : "Login",
        description : ""
    },

    register: {
        template: "../templates/register.html",
        title : "Register",
        description : ""
    },

    message : {
        template: "../templates/message.html",
        title : "Message",
        description : ""
    },
}

const locationHandler = async () => {
    var location = window.location.hash.replace("#", "");
    if (location.length == 0){
        location = '/';
    }

    console.log(location);

    const route = routes[location] || routes[404];
    const html = await fetch(route.template).then((response) => response.text());
    document.getElementById("content").innerHTML = html;
    document.title = route.title + " | Bizou";
}

window.addEventListener('hashchange', locationHandler);

locationHandler();