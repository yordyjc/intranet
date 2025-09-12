db = db.getSiblingDB('intranet');
db.users.insertOne({
    firstName: "Paolo",
    lastName: "Paz",
    username: "ppaz",
    password: "admin123",
    birthDate: new Date("1992-02-14"),
    email: "sl.paolo.paz@gmail.com",
    jobTitle: "Analista Programador Web",
    isActive: true,
    roles: ["admin"],
    createdAt: new Date(),
    updatedAt: new Date()
});