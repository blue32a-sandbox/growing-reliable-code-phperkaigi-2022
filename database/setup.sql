-- Create table

DROP TABLE IF EXISTS Bugs;
CREATE TABLE Bugs (
    bug_id      INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
    summary     VARCHAR(80) NOT NULL,
    reported_at DATETIME NOT NULL,
    status      VARCHAR(10) NOT NULL,
    PRIMARY KEY (bug_id)
);

-- Insert data

INSERT INTO Bugs (summary, reported_at, status)
    VALUES
        ('xxxxx', '2020-12-29 09:51:32', 'OPEN'),
        ('xxxxx', '2020-12-30 15:46:01', 'FIXED'),
        ('保存処理でクラッシュする', '2021-12-24 17:14:42', 'OPEN'),
        ('XMLのサポート', '2021-12-25 11:53:18', 'OPEN'),
        ('xxxxx', '2021-12-26 12:11:03', 'NEW'),
        ('パフォーマンスの向上', '2021-12-27 13:24:19', 'OPEN'),
        ('xxxxx', '2022-01-04 16:31:20', 'OPEN');
