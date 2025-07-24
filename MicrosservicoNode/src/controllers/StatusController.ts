import { Request, Response } from "express";

export class StatusController {
    static getStatus(req: Request, res: Response) {
        res.status(200).json({ status: "ok" });
    }
}

// Adicione esta linha para garantir que o método está disponível
export default StatusController;