using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Net.Mail;

namespace kommunikationsapi.code
{
    public static class MailServer
    {
        public static void Send(EpostMeddelande meddelande)
        {
            var client = new SmtpClient
            {
                Host = _Config.SmtpServiceHost,
                Port = _Config.SmtpServicePort,
                DeliveryMethod = SmtpDeliveryMethod.Network,
                UseDefaultCredentials = false,
                EnableSsl = true,
                Timeout = 10000,
                Credentials = new System.Net.NetworkCredential(_Config.SmtpServiceUserName, _Config.SmtpServicePassword)
            };

            var msg = new MailMessage
            {
                From = new MailAddress(meddelande.AvsandareEpost, meddelande.AvsandareEpost),
                Subject = meddelande.Amne,
                Body = meddelande.Meddelandetext,
                IsBodyHtml = false,
                DeliveryNotificationOptions = DeliveryNotificationOptions.OnFailure
            };

            msg.To.Add(meddelande.MottagareEpost);

            client.Send(msg);
        }
    }
}
