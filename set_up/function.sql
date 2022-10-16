--THE FIRST FUNCTION


DELIMITER //
CREATE FUNCTION update_detail()
RETURNS boolean
BEGIN
	DECLARE login_check tinyint(1);
    DECLARE date_check DATE;
    DECLARE year INT;
    DECLARE month INT;
    DECLARE day INT;
    DECLARE combine_date DATE;


    SELECT EXTRACT(YEAR FROM server_date) INTO year FROM server_detail;
    SELECT EXTRACT(MONTH FROM server_date) INTO month FROM server_detail;
    SELECT EXTRACT(DAY FROM server_date) INTO day FROM server_detail;

    SELECT CONCAT(CONCAT(CONCAT(CONCAT(year, '-'), month), '-'), day) INTO combine_date;

    SELECT first_login FROM server_detail INTO login_check;
    SELECT curdate() INTO date_check;

    IF combine_date != date_check
    || login_check = 0 THEN
    	UPDATE vcloud.server_detail
    	SET vcloud.server_detail.active_for = vcloud.server_detail.active_for + 1,
         vcloud.server_detail.server_date = sysdate(),
         vcloud.server_detail.first_login = 1;
         RETURN TRUE;
    END IF;
RETURN FALSE;
END //
