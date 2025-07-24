export interface IUserDataService {
    getUserData(): string;
    setUserData(data: string): void;
}