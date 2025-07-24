import express from "express";
import { StatusController } from "./controllers/StatusController";
import { ExternalController } from "./controllers/ExternalController"; // Nova importação
import { MockUserDataService } from "./services/MockUserDataService";

export function createApp() {
    const app = express();

    // Middleware
    app.use(express.json());

    // Services (Dependency Injection)
    const userDataService = new MockUserDataService();

    // Controllers
    app.get('/health', (req, res) => StatusController.getStatus(req, res));

    // Nova rota external
    app.get('/external', (req, res) => ExternalController.getExternalData(req, res));

    return app;
}