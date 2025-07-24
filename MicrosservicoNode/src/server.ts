import { createApp } from "./app";

const app = createApp();
const PORT = process.env.PORT || 3000;

app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);

    // Adicione este log para verificar as rotas registradas
    console.log('Available routes:');
    app._router.stack.forEach((middleware: any) => {
        if (middleware.route) {
            console.log(`${Object.keys(middleware.route.methods).join(', ').toUpperCase()} ${middleware.route.path}`);
        }
    });
});