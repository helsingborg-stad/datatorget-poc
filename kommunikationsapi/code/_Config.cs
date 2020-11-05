using System;

namespace kommunikationsapi.code
{
    public static class _Config
    {
        public static string MessageServiceHost => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_HOST") ?? "localhost";
        public static int MessageServicePort => int.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PORT") ?? "31001");
        public static string MessageServiceUserName => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_USERNAME") ?? "datatorget";
        public static string MessageServicePassword => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PASSWORD") ?? "datatorget";
        public static bool MessageServiceEnabled => bool.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_ENABLED") ?? "False");
        public static string SmtpServiceHost => System.Environment.GetEnvironmentVariable("SMTP_SERVICE_HOST") ?? "";
        public static int SmtpServicePort => int.Parse(System.Environment.GetEnvironmentVariable("SMTP_SERVICE_PORT") ?? "");
        public static string SmtpServiceUserName => System.Environment.GetEnvironmentVariable("SMTP_SERVICE_USERNAME") ?? "";
        public static string SmtpServicePassword => System.Environment.GetEnvironmentVariable("SMTP_SERVICE_PASSWORD") ?? "";
        public static string SendGridApiKey => System.Environment.GetEnvironmentVariable("SENDGRID_APIKEY") ?? "";
    }
}