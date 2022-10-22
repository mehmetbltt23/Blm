# Rightmove BLM File Reader &amp; Creator

### Install
```
composer require mehmetb/blm
```

### Usage

#### Reader
```
$reader = new Reader('data/test.BLM');
#results
$reader->getData();
$reader->getHeaders();
$reader->getDefinitions();
```

#### Creator

```
$creator = new Creator();

$struct = new DataStruct();
$struct->setDetail(DataStruct::AGENT_REF, '123455');
$struct->setDetail(DataStruct::ADDRESS_1, '29 Round'); 
$struct->setDetail('CUSTOM_YOU_FIELD', 'abcdefg');

# Add Feature
$struct->setFeature("Feature 1");
$struct->setFeature("Feature 2");
$struct->setFeature("Feature 3");

# Add Image
$struct->setImage('/path/image1.jpeg', 'Test Title');
$struct->setImage('/path/image2.jpeg', 'Test Title');
$struct->setImage('/path/image3.jpeg', 'Test Title');

# Add Floor Plan
$struct->setFloorPlan('/path/floor_plan1', 'Test Floor Plan Title');
$struct->setFloorPlan('/path/floor_plan2', 'Test Floor Plan Title');

# Add Document
$struct->setDocument('/path/document1', 'Test Document Title');
$struct->setDocument('/path/document2', 'Test Document Title');

# Add Virtual Tour
$struct->setVirtualTour('www.google.com', 'Test Virtual Tour Title');

$creator->push($struct);

# Export
$creator->getContent(); // returned BLM data
$creator->save('example/files','test.BLM'); // Creates a BLM file in the directory.
.....
```

#### Creating BLM with multiple data

``` 
    $data = [
        [
            'DataStruct::AGENT_REF' => '12345',
            'DataStruct::ADDRESS_1' => '29',
            'DataStruct::ADDRESS_2' => 'Rr 2',
            'DataStruct::TOWN' => 'Ketchikan',
            'DataStruct::POSTCODE1' => '999',
            'DataStruct::POSTCODE2' => '000',
            ...
            
            'images' => [
                'image1' => '/path/image1.jpeg',
                'image2' => '/path/image2.jpeg',
                'image3' => '/path/image3.jpeg',
            ],
            
            'documents' => [
                'document1' => '/path/document1.pdf',
                'document2' => '/path/document2.xls',
                'document3' => '/path/document3.docx',
            ]
        ]
    ];
    
    $creator = new Creator();
    foreach($data as $key => $value) {
        $struct = new DataStruct();
        switch($key) {
            case 'images':
                foreach ($value as $text => $image) {
                    $struct->setImage($image, $text);
                }
            break;
            
            case 'documents':
                foreach ($value as $text => $document) {
                    $struct->setImage($document, $text);
                }
            break;
            
            case 'virtual_tours':
                foreach ($value as $text => $virtual_tour) {
                    $struct->setFloorPlan($virtual_tour,$text);
                }
            break;
            
            case 'features':
                foreach ($value as $feature) {
                    $struct->setFeature($feature);
                }
            break;
            
            case 'floor_plans':
                foreach ($value as $text => $floor_plan) {
                    $struct->setFloorPlan($floor_plan,$text);
                }
            break;
            
            default:
                $struct->setDetail($key, $value);
            break;
        }
        
        $creator->push($struct);
    }
    
    $creator->save('example/files');
```

### Docker Build and Create Container

```
Before
   Remove Comments:  'Dockerfile:21' and 'Dockerfile:22'

- docker image build -t blm .
- docker container run -d --name blm-package blm
```

### **Docker Compose**

- docker-compose up -d --build