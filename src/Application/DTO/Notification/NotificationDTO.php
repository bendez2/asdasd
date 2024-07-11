<?php

namespace Application\DTO\Notification;

class NotificationDTO
{
    public string $company_uuid;
    public string $api_key;

    public string $template_id;
    public string $employee_email;
    public string $employee_name;


    public function __construct(string $company_uuid, string $api_key, string $template_id, string $employee_email, string $employee_name)
    {
        $this->company_uuid = $company_uuid;
        $this->api_key = $api_key;
        $this->template_id = $template_id;
        $this->employee_email = $employee_email;
        $this->employee_name = $employee_name;
    }
}