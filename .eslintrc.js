module.exports = {
    "env": {
        "browser": true,
        "node": true,
        "es6":true
    },
    "parserOptions": {
        "ecmaVersion": 6,
        "sourceType": "module",
        "ecmaFeatures": {
            "jsx": true
        }
    },
    "parser": "babel-eslint",
    "rules": {
        "semi":2,
    },
    "settings": {
        "import/resolver": {
            "alias": {
                "map": [
                    ["@rules", "./resource/lib/rules"]
                ],
                "extensions": [".js", ".vue", ".json"]
            }
        }
    },
};
