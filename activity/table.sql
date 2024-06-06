CREATE TABLE Channel (
    channelid SERIAL PRIMARY KEY ,
    channelname TEXT NOT NULL,
    channeldescription var(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE UserData (
    userid  SERIAL PRIMARY KEY ,
    username TEXT NOT NULL UNIQUE,
    userdescription TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE DailyReport (
    reportid SERIAL PRIMARY KEY,
    channelid INTEGER NOT NULL,
    userid INTEGER NOT NULL,
    active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (channelid) REFERENCES Channel(channelid),
    FOREIGN KEY (userid) REFERENCES UserData(userid)
);
