DROP TABLE IF EXISTS subcomments;
DROP TABLE IF EXISTS comments;

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) not null,
    email VARCHAR(100) not null,
    comment VARCHAR(255) not null,
    date DATETIME not null
);
 
CREATE TABLE subcomments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) not null,
    email VARCHAR(100) not null,
    comment VARCHAR(255) not null,
    date DATETIME not null,
    fk_comment INT,
    FOREIGN KEY (fk_comment) REFERENCES comments(id)
);
 
INSERT INTO `comments` VALUES
(1, 'Kuruk Dang', 'kurdan@autozone-inc.info', 'Copiosae definitionem an quo. Cum vocent deserunt reprehendunt no, movet blandit consulatu cum cu. Usu ad vide equidem. Erat aliquando qui cu.', DATE_SUB(now(), INTERVAL FLOOR(RAND()*2880) MINUTE)),
(2, 'Naomi Archibald', 'na.ar@progressenergyinc.info', 'Habeo pericula in quo, fugit aeque no est. Usu ea tritani postulant, at vix iracundia euripidis. Te vel meliore oporteat. Nec modo evertitur id, ea forensibus vituperatoribus nam, et vel brute expetendis. Vis aperiri definitionem eu.', DATE_SUB(now(), INTERVAL FLOOR(RAND()*2880) MINUTE)),
(3, 'Wahida Stiltner', 'wah-sti@diaperstack.com', 'Ex feugait invenire dignissim est. Dolor disputando his in, vel detraxit comprehensam te, te quo consul vidisse intellegebat. Vix eu case clita nusquam, ubique discere erroribus usu et. Ius autem deseruisse disputando ex.', DATE_SUB(now(), INTERVAL FLOOR(RAND()*2880) MINUTE)),
(4, 'Angharad Dang', 'an-da@autozone-inc.info', 'Lorem ipsum dolor sit amet, fugit aliquip invidunt ad nec. Eos cu hendrerit delicatissimi, periculis persecuti reprehendunt pro ut. Ei mel veniam suscipit recusabo, ne posse nonumes gloriatur qui, no vis eligendi accusata.', now());
 
INSERT INTO `subcomments` VALUES
(1, 'Natalie Brightwell', 'natal.bright@autozone-inc.info', 'Doming sapientem interesset eu vix, et iusto aeterno deleniti pri. Ius legere volutpat ad, te accusata partiendo vix. Has eu legere explicari, veniam petentium incorrupte at mel. At vitae disputando sea, no vix reque quaestio.', DATE_SUB(now(), INTERVAL FLOOR(RAND()*2880) MINUTE), 1),
(2, 'Ophira Dodge', 'oph-do@egl-inc.info', 'No utinam invenire splendide his, mea sale elitr te. Alterum suavitate eum ut. Vix ullum facilis no, at sea erant conceptam posidonium. Labores consetetur sadipscing sed ea, cu prima nominavi vim. Ex mandamus qualisque qui, sed errem fabellas.', DATE_SUB(now(), INTERVAL FLOOR(RAND()*2880) MINUTE), 3),
(3, 'Sudeva Mclemore', 'sudev.mc@egl-inc.info', 'At epicuri splendide per, ne eos paulo melius. At has odio periculis, mel urbanitas assentior te. Elit dicit dolore ne ius, ut sea reque senserit. Dicunt verear quaerendum vis at. Ne amet albucius usu, sed populo primis gloriatur ea.', now(), 1)