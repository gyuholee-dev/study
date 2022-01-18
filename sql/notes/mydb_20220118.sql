---- educ 교육관리
-- seqn 자동번호
-- numb 사번
-- date 교육일자
-- hour 교육시간
-- educ 교육명
-- kind 교육구분
-- auth 시행기관
-- plce 교육장소

CREATE TABLE educ
(
  seqn INT AUTO_INCREMENT,
  numb CHAR(4),
  date CHAR(10),
  hour INT,
  educ CHAR(30),
  kind CHAR(1),
  auth CHAR(30),
  plce CHAR(2),
  PRIMARY KEY(seqn)
);

Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1111','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1112','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1113','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1114','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1115','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1116','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1117','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1118','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1119','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1120','2020-09-18','2','리더십 함양','D','산업공단','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1113','2020-11-05','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1114','2020-11-06','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1115','2020-11-07','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1116','2020-11-08','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1117','2020-11-09','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1118','2020-11-10','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1119','2020-11-11','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1120','2020-11-12','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1121','2020-11-13','16','회계실무 교육','F','본사','11');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1114','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1115','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1116','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1117','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1118','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1119','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1120','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1121','2021-02-18','4','예절 교육','D','정훈서비스','12');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1112','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1113','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1114','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1115','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1116','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1117','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1118','2021-03-16','24','인사 실무','F','효성학교','14');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1111','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1112','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1113','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1114','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1115','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1116','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1117','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1118','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1119','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1120','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1121','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1122','2021-05-09','32','초급관리자 교육','D','산업인력공단','15');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1114','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1115','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1116','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1117','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1118','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1119','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1120','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
Insert into Educ(Numb,Date,Hour,Educ,Kind,Auth,Plce) values('1121','2021-07-05','24','네트워크 관리','F','동신네트웍스','16');
