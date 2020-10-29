using System;

namespace bokningsapi.code
{
    public class Resurstid
    {
        public string ResurstidId { get; set; }
        public string ResursId { get; set; }
        public DateTime StartTid { get; set; }
        public DateTime SlutTid { get; set; }
        public int Bokningsnr { get; set; }
        public bool Tillganglig => Bokningsnr == 0;

        public Resurstid(string resursid, DateTime starttid, DateTime sluttid, int bokningsnr)
        {
            ResurstidId = GetId(resursid, starttid);
            ResursId = resursid;
            StartTid = starttid;
            SlutTid = sluttid;
            Bokningsnr = bokningsnr;
        }

        public static string GetId(string resursid, DateTime starttid) => $"{resursid}/{starttid.ToString("yyyyMMddHH")}";
    }
}