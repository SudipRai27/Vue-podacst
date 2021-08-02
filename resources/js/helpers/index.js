import router from "@/router";

export const setHttpToken = token => {
    if (!token) {
        localStorage.removeItem("authToken");
        return (window.axios.defaults.headers.common["Authorization"] =
            "Bearer ");
    }
    localStorage.setItem("authToken", token);
    return (window.axios.defaults.headers.common["Authorization"] =
        "Bearer " + token);
};

export const removeValidationErrors = (errors, field) => {
    if (errors && errors[field] && errors[field].length > 0) {
        delete errors[field];
    }
    return errors;
};

export const redirectTo = statusCode => {
    switch (statusCode) {
        case 404:
            return router.replace({
                name: "404"
            });
        case 403:
            return router.replace({
                name: "403"
            });
        default:
            return;
    }
};
