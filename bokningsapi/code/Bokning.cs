using System;
using System.Linq;
using System.Collections.Generic;
using System.IO;

namespace bokningsapi.code
{
    public class Bokning
    {
        public int Bokningsnr { get; set; }
        public DateTime StartTid { get; set; }
        public DateTime SlutTid { get; set; }
        public Resurstid[] Resurstider { get; set; }
        public int Kundnr { get; set; }
        public int Pris { get; set; }
        public int BeloppBetalt { get; set; }
        public bool Bekraftad { get; set; }
        public bool Avbokad { get; set; }
        public DateTime SenastUppdaterad { get; set; }

        public Bokning()
        {
        }

        public Bokning(string resursId, DateTime startTid, DateTime slutTid, int kundnr)
        {
            var resurs = _DataStore.GetResurs(resursId);
            Bokningsnr = _DataStore.HamtaNastaBokningsnr();
            Resurstider = resurs.GetResurstider(startTid, slutTid, Bokningsnr).ToArray();
            Kundnr = kundnr;
            Pris = resurs.Timpris * Resurstider.Length;
            BeloppBetalt = 0;
            Bekraftad = false;
            Avbokad = false;
            SenastUppdaterad = DateTime.Now;
            StartTid = startTid;
            SlutTid = slutTid;
        }
    }
}