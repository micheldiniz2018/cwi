import { Request, Response } from "express";

export class ExternalController {
    static getExternalData(req: Request, res: Response) {
        const { input } = req.query;

        if (!input) {
            return res.status(400).json({
                error: "Parâmetro 'input' é obrigatório"
            });
        }

        res.status(200).json({
            receivedInput: input,
            message: "Dado externo recebido com sucesso"
        });
    }
}