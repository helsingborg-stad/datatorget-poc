using System;

namespace kommunikationsapi.code
{
    public static class _Config
    {
        public static string MessageServiceHost => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_HOST") ?? "localhost";
        public static int MessageServicePort => int.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PORT") ?? "30006");
        public static string MessageServiceUserName => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_USERNAME") ?? "datatorget";
        public static string MessageServicePassword => System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_PASSWORD") ?? "datatorget";
        public static bool MessageServiceEnabled => bool.Parse(System.Environment.GetEnvironmentVariable("MESSAGE_SERVICE_ENABLED") ?? "False");
    }
}