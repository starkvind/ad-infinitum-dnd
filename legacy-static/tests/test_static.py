import html.parser
from pathlib import Path
import re
import sys
import unittest

HERE = Path(__file__).resolve().parents[1]
sys.path.insert(0, str(HERE))
from build import build, DEST

class Checker(html.parser.HTMLParser):
    def __init__(self):
        super().__init__()
        self.links = []
        self.tags = []
        self.attribs = []
    def handle_starttag(self, tag, attrs):
        self.tags.append(tag)
        self.attribs.extend(attrs)
        if tag == "a":
            self.links.append(dict(attrs).get("href", ""))

class StaticTests(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        build()
        cls.pages = list(DEST.glob("*.html"))
    def test_only_allowlisted_files(self):
        actual = {str(p.relative_to(DEST)) for p in DEST.rglob("*") if p.is_file()}
        expected = {"index.html","actualizaciones.html","ylat.html","archivo.html","pendiente.html","404.html","styles.css","assets/adinfinitumlogo.png"}
        self.assertEqual(actual, expected)
    def test_no_active_surfaces(self):
        blocked = {"script","form","input","textarea","button","iframe","object","embed"}
        for page in self.pages:
            parser = Checker()
            parser.feed(page.read_text(encoding="utf-8"))
            self.assertFalse(blocked.intersection(parser.tags), page)
            for key,value in parser.attribs:
                self.assertFalse(key.lower().startswith("on"), (page,key))
                if key in ("href","src","action"):
                    self.assertFalse(re.match(r"(?i)\\s*(javascript:|data:text/html)", value or ""))
    def test_all_local_links_resolve(self):
        for page in self.pages:
            parser = Checker()
            parser.feed(page.read_text(encoding="utf-8"))
            for link in parser.links:
                if link.startswith("https://") or link.startswith("#"):
                    continue
                self.assertTrue(link and not link.startswith("http://"))
                self.assertTrue((DEST / link.split("#")[0]).is_file(), (page,link))
    def test_mobile_and_error(self):
        css=(DEST / "styles.css").read_text(encoding="utf-8")
        self.assertIn("@media(max-width:680px)", css)
        for page in self.pages:
            text=page.read_text(encoding="utf-8")
            self.assertIn('name="viewport"', text)
            self.assertIn('http-equiv="Content-Security-Policy"', text)
            self.assertIn('lang="es"', text)
        self.assertIn("Error 404", (DEST / "404.html").read_text())
    def test_no_secret_or_dump_fragments(self):
        for path in DEST.rglob("*"):
            if path.is_file() and path.suffix in (".html",".css"):
                content=path.read_text(encoding="utf-8").lower()
                for marker in ("create table `","insert into `","db2243630","mysqli_","mysql_connect","password=","session_start","<script"):
                    self.assertNotIn(marker, content, (path,marker))
    def test_historical_content_is_labeled(self):
        self.assertIn("2016-03-13", (DEST / "actualizaciones.html").read_text())
        self.assertIn("dnd_map_locations #1", (DEST / "ylat.html").read_text())
        self.assertIn("canon", (DEST / "ylat.html").read_text().lower())
        self.assertIn("No restaurado", (DEST / "archivo.html").read_text())

if __name__ == "__main__":
    unittest.main()
