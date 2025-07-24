import { IUserDataService } from "../interfaces/IUserDataService";

export class UserDataService implements IUserDataService {
    private data: string = "";

    getUserData(): string {
        return this.data || "Nenhum dado foi inserido ainda";
    }

    setUserData(data: string): void {
        this.data = data;
    }
}