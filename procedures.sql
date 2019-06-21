
  CREATE PROCEDURE selectUser(IN u_id int(11))  
  BEGIN  
  SELECT  oc.company_name,uc.recruited_date,uc.working_status,uc.user_company_id,uc.work_role,uc.contract_period 
  FROM USER_COMPANY uc JOIN out_source_company oc 
  ON uc.company_id = oc.company_id 
  WHERE user_id=u_id ORDER BY user_company_id DESC; 
  END;  
   