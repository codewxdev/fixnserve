<?php


namespace App\Domains\Audit\Controllers;


class AuditController
{
    public function index()
    {
        return view('Admin.audit_compliance.admin_action_audit.index');
    }

    public function financialTransactionAudit()
    {
        return view('Admin.audit_compliance.financial_transaction_audit.index');
    }


    public function securityAccessAudit()
    {
        return view('Admin.audit_compliance.security_access_audit.index');
    }

    public function dataAccessPrivacyCompliance()
    {
        return view('Admin.audit_compliance.data_access_&_privacy_compliance.index');
    }


    public function regulatoryReportingExports()
    {
        return view('Admin.audit_compliance.regulatory_reporting_&_exports.index');
    }

    public function dataRetentionLegalHolds()
    {
        return view('Admin.audit_compliance.data_retention_&_legal_holds.index');
    }   
}