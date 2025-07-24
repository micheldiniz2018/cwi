import { IUserDataService } from "../interfaces/IUserDataService";

export class MockUserDataService implements IUserDataService {
    private data: string = "Dado mockado padrão";

    getUserData(): string {
        return this.data;
    }

    setUserData(data: string): void {
        this.data = data;
    }
}