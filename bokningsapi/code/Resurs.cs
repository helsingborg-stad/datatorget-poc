using System;
using System.Linq;
using System.Xml.Linq;
using System.Collections.Generic;

namespace bokningsapi.code
{
    /// <summary>
    /// 
    /// </summary>
    public class Resurs
    {
        public string ResursId { get; set; }
        public string Namn { get; set; }
        public string Typ { get; set; }
        public int Timpris { get; set; }
        public SortedDictionary<string, string> Egenskaper { get; set; }
        private Dagsschema[] Dagsscheman { get; set; }

        public Resurs()
        {
        }

        public Resurs(XElement src)
        {
            ResursId = src.Attribute("id").Value;
            Namn = src.Attribute("name").Value;
            Typ = src.Attribute("type").Value;
            Timpris = int.Parse(src.Attribute("pricePerHour").Value);
            Egenskaper = new SortedDictionary<string, string>(src.Descendants("property").ToDictionary(xe => xe.Attribute("key").Value, xe => xe.Attribute("value").Value));
            Dagsscheman = src.Element("schedule").Elements("day").Select(xe => new Dagsschema(xe)).ToArray();
        }

        public IEnumerable<Resurstid> GetResurstider(DateTime starttid, DateTime sluttid, int bokningsnr)
        {
            var datum = DateTime.MinValue.Date;
            Dagsschema dagsschema = null;

            // Make sure there are no minutes
            starttid = starttid.Date.AddHours(starttid.Hour);
            sluttid = sluttid.Date.AddHours(sluttid.Hour);

            for (var tid = starttid; tid < sluttid; tid = tid.AddHours(1))
            {
                if (tid.Date != datum)
                {
                    datum = tid.Date;
                    dagsschema = HamtaDagsschema(tid.Date.DayOfWeek);
                }
                if (dagsschema != null && tid.Hour >= dagsschema.StartTid && tid.Hour < dagsschema.SlutTid)
                    yield return new Resurstid(ResursId, Namn, tid, tid.AddHours(1), bokningsnr);
            }
        }

        private Dagsschema HamtaDagsschema(DayOfWeek veckodag)
        {
            foreach (var ds in Dagsscheman)
                if (ds.Veckodag == veckodag)
                    return ds;
            return null;
        }
    }
}
