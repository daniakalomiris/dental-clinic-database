/* uncomment line below for first run on local server only */
-- create database db;

use db;

create table Clinic(
    CIC integer PRIMARY KEY ,
    name VARCHAR(64)
);

create table Dentist(
    DID INTEGER PRIMARY KEY,
    name VARCHAR(64),
    CIC INTEGER,
    FOREIGN KEY (CIC) REFERENCES Clinic(CIC)
);

create table Assistant(
    DID INTEGER,
    AID INTEGER not null,
    name varchar(64),
    FOREIGN KEY (DID) REFERENCES Dentist(DID)
);

create table Patient(
    PID INTEGER PRIMARY KEY,
    name VARCHAR(64)
);

create table Receptionist(
    RID INTEGER PRIMARY KEY,
    name varchar(64),
    CIC INTEGER,
    FOREIGN KEY (CIC) REFERENCES Clinic(CIC)
);

create table Appointment(
    AID INTEGER PRIMARY KEY,
    CIC INTEGER,
    FOREIGN KEY (CIC) REFERENCES Clinic(CIC),
    PID INTEGER,
    FOREIGN KEY (PID) REFERENCES Patient(PID),
    DID INTEGER,
    FOREIGN KEY (DID) REFERENCES Dentist(DID),
    attended boolean not null default TRUE,
    date DATE not null,
    time time
);

create table Treatment(
    AID INTEGER PRIMARY KEY ,
    FOREIGN KEY (AID) REFERENCES Appointment(AID),
    treatment VARCHAR(250),
    executedByDentist boolean not null default true,
    executedByAssistant INT NULL,
    FOREIGN KEY (executedByAssistant) REFERENCES Assistant(DID)
);

create table Bill(
    BID INTEGER PRIMARY KEY,
    paid boolean not null default false,
    amount float(9,2),
    AID INTEGER,
    FOREIGN KEY (AID) REFERENCES Appointment(AID),
    processedBy INTEGER,
    FOREIGN KEY (processedBy) REFERENCES Receptionist(RID)
);

INSERT INTO Clinic(CIC, name) VALUES (1,'riveclic');
INSERT INTO Clinic(CIC, name) VALUES (2,'mtlclic');
INSERT INTO Clinic(CIC, name) VALUES (3,'covidclic');

INSERT INTO Dentist(DID, name, CIC) VALUES (1,'schmidt',1);
INSERT INTO Dentist(DID, name, CIC) VALUES (2,'taylor',1);
INSERT INTO Dentist(DID, name, CIC) VALUES (3,'camara',1);
INSERT INTO Dentist(DID, name, CIC) VALUES (4,'telmo',1);
INSERT INTO Dentist(DID, name, CIC) VALUES (5,'smurf',2);
INSERT INTO Dentist(DID, name, CIC) VALUES (6,'snitzl',2);
INSERT INTO Dentist(DID, name, CIC) VALUES (7,'pringles',2);
INSERT INTO Dentist(DID, name, CIC) VALUES (8,'lays',2);
INSERT INTO Dentist(DID, name, CIC) VALUES (9,'davis',3);
INSERT INTO Dentist(DID, name, CIC) VALUES (10,'richards',3);

INSERT INTO Assistant(DID, AID, name) VALUES (1,1,'sarah');
INSERT INTO Assistant(DID, AID, name) VALUES (1,2,'nadia');
INSERT INTO Assistant(DID, AID, name) VALUES (2,3,'salma');
INSERT INTO Assistant(DID, AID, name) VALUES (5,4,'hayek');
INSERT INTO Assistant(DID, AID, name) VALUES (8,5,'nagwa');
INSERT INTO Assistant(DID, AID, name) VALUES (3,1,'sarah');
INSERT INTO Assistant(DID, AID, name) VALUES (7,2,'nadia');
INSERT INTO Assistant(DID, AID, name) VALUES (9,4,'hayek');
INSERT INTO Assistant(DID, AID, name) VALUES (6,5,'nagwa');
INSERT INTO Assistant(DID, AID, name) VALUES (10,6,'haidi');

INSERT INTO Patient(PID, name) VALUES (1,'alaa');
INSERT INTO Patient(PID, name) VALUES (2,'nedjma');
INSERT INTO Patient(PID, name) VALUES (3,'nani');
INSERT INTO Patient(PID, name) VALUES (4,'zaha');
INSERT INTO Patient(PID, name) VALUES (5,'zalema');
INSERT INTO Patient(PID, name) VALUES (6,'shiri');
INSERT INTO Patient(PID, name) VALUES (7,'kassir');
INSERT INTO Patient(PID, name) VALUES (8,'hend');
INSERT INTO Patient(PID, name) VALUES (9,'nesma');
INSERT INTO Patient(PID, name) VALUES (10,'samir');
INSERT INTO Patient(PID, name) VALUES (11,'samantha');
INSERT INTO Patient(PID, name) VALUES (12,'sami');
INSERT INTO Patient(PID, name) VALUES (13,'sandi');
INSERT INTO Patient(PID, name) VALUES (14,'karma');
INSERT INTO Patient(PID, name) VALUES (15,'alaa');
INSERT INTO Patient(PID, name) VALUES (16,'manyal' );
INSERT INTO Patient(PID, name) VALUES (17,'amal');
INSERT INTO Patient(PID, name) VALUES (18,'manal');
INSERT INTO Patient(PID, name) VALUES (19,'asma');
INSERT INTO Patient(PID, name) VALUES (20,'nader');
INSERT INTO Patient(PID, name) VALUES (21,'maher');

INSERT INTO Receptionist(RID, name, CIC) VALUES (1,'chantal',1);
INSERT INTO Receptionist(RID, name, CIC) VALUES (2,'helene',1);
INSERT INTO Receptionist(RID, name, CIC) VALUES (3,'florence',2);
INSERT INTO Receptionist(RID, name, CIC) VALUES (4,'antoine',2);
INSERT INTO Receptionist(RID, name, CIC) VALUES (5,'miguel',3);

INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (1,1,12,3,TRUE,'2020-03-20','08:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (2,1,3,4,TRUE,'2020-03-22','12:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (3,3,7,9,false,'2020-02-20','14:30:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (4,2,10,6,TRUE,'2020-01-22','16:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (5,1,12,3,false,'2020-03-21','17:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (6,2,7,7,false,'2020-02-14','14:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (7,3,2,1,false,'2020-01-01','09:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (8,2,4,5,TRUE,'2020-04-01','18:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (9,1,21,3,TRUE,'2020-02-29','15:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (10,3,20,10,TRUE,'2020-03-20','08:00:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (11,2,19,6,false,'2020-03-01','10:30:00');
INSERT INTO Appointment(AID, CIC, PID, DID, attended, date, time) VALUES (12,1,9,2,TRUE,'2020-03-20','08:00:00');

INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (1,'cleaning',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (12,'cleaning,removal',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (8,'extraction,dentures,fillings',false,5);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (10,'crowns and caps',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (9,'bonding',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (5,'cleaning,removal',false,3);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (6,'bridges',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (2,'removal',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (4,'sealant',false,6);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (3,'oral cancer examination',true,null);
INSERT INTO Treatment(AID,treatment, executedByDentist, executedByAssistant) VALUES (7,'root canal',true,null);

INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (1,true,300.69,1,2);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (2,true,3000.99,12,1);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (3,false,169.99,8,3);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (4,true,200.69,6,4);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (5,true,5690.10,3,5);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (6,false,1200.00,7,1);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (7,true,1900.99,2,1);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (8,true,2001.99,4,4);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (9,false,100.00,5,1);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (10,false,2300.99,9,2);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (11,true,4300.99,10,5);
INSERT INTO Bill(BID, paid, amount, AID, processedBy) VALUES (12,false,9732.99,11,3);