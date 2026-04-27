<?php


namespace  App\Domains\Audit\Controllers\Front;


class AuditController
{
    public function index()
    {
        return view('admin.audit_compliance.admin_action_audit.index');
    }

    public function financialTransactionAudit()
    {
        return view('admin.audit_compliance.financial_transaction_audit.index');
    }


    public function securityAccessAudit()
    {
        return view('admin.audit_compliance.security_access_audit.index');
    }

    public function dataAccessPrivacyCompliance()
    {
        return view('admin.audit_compliance.data_access_&_privacy_compliance.index');
    }


    public function regulatoryReportingExports()
    {
        return view('admin.audit_compliance.regulatory_reporting_&_exports.index');
    }

    public function dataRetentionLegalHolds()
    {
        return view('admin.audit_compliance.data_retention_&_legal_holds.index');
    }  
    
    // public function userActivityAudit()
    // {
    //     return view('admin.audit_compliance.audit_search.index');
    // }

    public function auditSearchReplayForensics()
    {
        return view('admin.audit_compliance.audit_search.index');
    }   

    public function complianceMonitoringAlerts()
    {
        return view('admin.audit_compliance.compiliance_monitoring_&_ai.index');
    }
}