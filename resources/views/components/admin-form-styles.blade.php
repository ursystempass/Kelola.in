@once
    <style>
        /* Style form/admin bersama. Dipakai semua halaman admin lewat <x-admin-form-styles />. */
        #adminApp main input:not([type='hidden']):not([type='radio']):not([type='checkbox']),
        #adminApp main select,
        #adminApp main textarea {
            box-sizing: border-box;
            width: 100%;
            height: 48px;
            padding: 12px 14px;
            border: 1px solid #D5DCE8;
            border-radius: 10px;
            background-color: #FFFFFF;
            color: var(--ink, #0F2B5C);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.4;
            box-shadow: none;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        #adminApp main input.admin-input-icon {
            padding-left: 40px;
        }

        #adminApp main textarea {
            height: auto;
            min-height: 110px;
            padding-top: 12px;
            padding-bottom: 12px;
            resize: vertical;
        }

        #adminApp main input::placeholder,
        #adminApp main select::placeholder,
        #adminApp main textarea::placeholder {
            color: #9AA5B8;
            opacity: 1;
        }

        #adminApp main input:focus,
        #adminApp main select:focus,
        #adminApp main textarea:focus {
            border-color: var(--brand, #1A6CF0);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            outline: none;
        }

        #adminApp main input[class*='border-rose-400'],
        #adminApp main select[class*='border-rose-400'],
        #adminApp main textarea[class*='border-rose-400'],
        #adminApp main input.is-invalid,
        #adminApp main select.is-invalid,
        #adminApp main textarea.is-invalid,
        #adminApp main input.is-invalid:focus,
        #adminApp main select.is-invalid:focus,
        #adminApp main textarea.is-invalid:focus {
            border-color: #E11D48;
        }

        #adminApp main label {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        #adminApp main .admin-optional {
            font-size: 12px;
            font-weight: 400;
            color: #94A3B8;
        }

        #adminApp main .admin-error {
            margin-top: 6px;
            font-size: 13px;
            font-weight: 400;
            color: #E11D48;
        }

        #adminApp main .admin-card {
            background-color: #FFFFFF;
            border: 1px solid var(--line, #E5EAF3);
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(15, 43, 92, 0.04);
        }

        #adminApp main .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-sizing: border-box;
            height: 46px;
            padding: 0 22px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            line-height: 1;
            text-decoration: none;
            transition: background-color 0.15s ease, color 0.15s ease, border-color 0.15s ease, box-shadow 0.15s ease;
        }

        #adminApp main .admin-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        #adminApp main .admin-btn-search {
            height: 48px;
        }

        #adminApp main .admin-btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
        }

        #adminApp main .admin-btn-primary {
            background-color: var(--brand, #1A6CF0);
            color: #FFFFFF;
        }

        #adminApp main .admin-btn-primary:hover {
            background-color: var(--brand-dark, #155BD0);
        }

        #adminApp main .admin-btn-primary:active {
            background-color: var(--brand-active, #114AB0);
        }

        #adminApp main .admin-btn-secondary {
            background-color: #F1F5F9;
            border-color: #E2E8F0;
            color: #475569;
        }

        #adminApp main .admin-btn-secondary:hover {
            background-color: #E2E8F0;
        }

        #adminApp main .admin-btn-danger {
            background-color: #FFF1F2;
            border-color: #FECDD3;
            color: #E11D48;
        }

        #adminApp main .admin-btn-danger:hover {
            background-color: #FFE4E6;
        }

        #adminApp main .admin-link {
            color: var(--brand, #1A6CF0);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }

        #adminApp main .admin-link:hover {
            color: var(--brand-dark, #155BD0);
            text-decoration: underline;
        }

        #adminApp main .admin-link:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            border-radius: 6px;
        }

        #adminApp main table {
            width: 100%;
            border-collapse: collapse;
        }

        #adminApp main thead {
            background-color: #F8FAFC;
        }

        #adminApp main thead tr {
            border-bottom: 1px solid var(--line, #E5EAF3);
        }

        #adminApp main th {
            padding: 14px 16px;
            color: #475569;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        #adminApp main td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--line, #E5EAF3);
            color: #334155;
            font-size: 14px;
        }

        #adminApp main .admin-table tbody tr {
            height: 54px;
            transition: background-color 0.15s ease;
        }

        #adminApp main .admin-table tbody tr:hover {
            background-color: #F8FAFC;
        }

        #adminApp main td.admin-empty {
            padding: 40px 16px;
            text-align: center;
            color: #94A3B8;
        }
    </style>
@endonce
