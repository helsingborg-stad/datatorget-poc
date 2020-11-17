using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Net.Mail;
using MinimalSendGrid;

namespace kommunikationsapi.code
{
    public static class MailServer
    {
        public static void SendBySmtp(EpostMeddelande meddelande)
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

        public static async Task SendBySendGrid(EpostMeddelande meddelande)
        {
            var msg = new MessageBuilder()
                .SetFrom(meddelande.AvsandareEpost)
                .AddTo(meddelande.MottagareEpost)
                .SetSubject(meddelande.Amne)
                .AddBody(meddelande.Meddelandetext)
                .Build();

            var sender = new HttpV3MessageSender(_Config.SendGridApiKey);
            var result = await sender.Send(msg);
        }
    }
}
