module.exports = {
    theme: {
        extend: {},
        customForms: (theme) => ({
            default: {
                'input, checkbox, select, textarea': {
                    backgroundColor: theme('colors.gray.200'),
                },
            },
        }),
    },
    variants: {
        textDecoration: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
    },
    plugins: [
        require('@tailwindcss/custom-forms'),
    ]
};
